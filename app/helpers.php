<?php

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use App\Models\FileOrder;
use App\Models\DiscountApply;
use App\Models\PhysicalOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

function convertToOrdinal($number)
{
  if (!is_numeric($number) || $number < 1) {
    return "Error!";
  }

  $lastDigit = $number % 10;
  $secondLastDigit = floor(($number % 100) / 10);

  if ($secondLastDigit == 1) {
    $suffix = "th";
  } else {
    switch ($lastDigit) {
      case 1:
        $suffix = "st";
        break;
      case 2:
        $suffix = "nd";
        break;
      case 3:
        $suffix = "rd";
        break;
      default:
        $suffix = "th";
    }
  }

  return $number . $suffix;
}

function formatISBN($isbn)
{
  // Remove any existing hyphens or spaces
  $isbn = str_replace(['-', ' '], '', $isbn);

  // Check if the ISBN is 13 digits long
  if (strlen($isbn) == 13) {
    // Format as 3-1-2-6-1
    return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 1) . '-' . substr($isbn, 4, 2) . '-' . substr($isbn, 6, 6) . '-' . substr($isbn, 12, 1);
  }

  // Invalid ISBN number
  return "Invalid ISBN number";
}

function getBookBestDiscount($book)
{
  $discount = null;
  $specficDiscount = Discount::whereHas('eventDiscount', function (Builder $query) use ($book) {
    $query->where([
      ['apply_for_all_books', '=', false],
      ['start_date', '<=', date('Y-m-d')],
      ['end_date', '>=', date('Y-m-d')],
    ])->whereHas('booksApplied', function (Builder $query) use ($book) {
      $query->where([
        ['book_id', '=', $book->id]
      ]);
    });
  })->orderBy('discount', 'desc')->first();

  $allDiscount = Discount::whereHas('eventDiscount', function (Builder $query) {
    $query->where([
      ['apply_for_all_books', '=', true],
      ['start_date', '<=', date('Y-m-d')],
      ['end_date', '>=', date('Y-m-d')],
    ]);
  })->orderBy('discount', 'desc')->first();

  if ($specficDiscount && $allDiscount) {
    if ($specficDiscount->discount > $allDiscount->discount) {
      $discount = $specficDiscount;
    } else {
      $discount = $allDiscount;
    }
  } else if ($specficDiscount) {
    $discount = $specficDiscount;
  } else if ($allDiscount) {
    $discount = $allDiscount;
  }

  return $discount;
}

// Objects are passed by reference in PHP
function refineBookData(Book $book, bool $removeFilePath = true)
{
  $book->edition = convertToOrdinal($book->edition) . ' Edition';
  $book->image = route('temporary-url.image', ['path' => $book->image]);
  $book->publication_date = date('F j, Y', strtotime($book->publication_date));
  $book->isbn = formatISBN($book->isbn);

  $authors = [];
  foreach ($book->authors as $author) {
    $authors[] = $author->name;
  }
  $book->authors = implode(', ', $authors);

  $categories = [];
  foreach ($book->categories as $category) {
    $categories[] = $category->name;
  }
  $book->categories = implode(', ', $categories);

  $temp = getBookBestDiscount($book);
  $book->discount = $temp ? $temp->discount : 0;

  if ($removeFilePath && $book->fileCopy)
    unset($book->fileCopy->path);

  return $book;
}

function displayRatingStars($avgRating)
{
  $fullStar = '<i class="bi bi-star-fill"></i>';
  $halfStar = '<i class="bi bi-star-half"></i>';
  $emptyStar = '<i class="bi bi-star"></i>';
  $stars = '';

  for ($i = 0; $i < 5; $i++) {
    if ($avgRating >= ($i + 0.8)) {
      $stars .= $fullStar;
    } elseif ($avgRating >= ($i + 0.3)) {
      $stars .= $halfStar;
    } else {
      $stars .= $emptyStar;
    }
  }

  return $stars;
}

function recalculateOrderValue($id)
{
  if (!auth()->check()) return false;

  DB::transaction(function () use ($id) {
    $totalPrice = 0;
    $totalDiscount = 0;

    $physicalOrder = PhysicalOrder::find($id);
    $fileOrder = FileOrder::find($id);

    DiscountApply::where('order_id', $id)->delete();

    if ($physicalOrder) {
      foreach ($physicalOrder->physicalCopies  as $physicalCopy) {
        $price = $physicalCopy->price;
        $discount = getBookBestDiscount(Book::find($physicalCopy->id));
        $amount = $physicalCopy->pivot->amount;

        if ($discount) {
          $totalPrice += round(($price * (100.0 - $discount->discount)) / 100, 2) * $amount;
          $totalDiscount += round(($price * $discount->discount) / 100.0, 2) * $amount;

          if (!DiscountApply::where([
            ['discount_id', '=', $discount->id]
          ])->exists())
            DiscountApply::create([
              'order_id' => $id,
              'discount_id' => $discount->id,
            ]);
        } else {
          $totalPrice += $price * $amount;
        }
      }
    }

    if ($fileOrder) {
      foreach ($fileOrder->fileCopies as $fileCopy) {
        $price = $fileCopy->price;
        $discount = getBookBestDiscount(Book::find($fileCopy->id));

        if ($discount) {
          $totalPrice += round(($price * (100.0 - $discount->discount)) / 100, 2);
          $totalDiscount += round(($price * $discount->discount) / 100.0, 2);

          if (!DiscountApply::where([
            ['discount_id', '=', $discount->id]
          ])->exists())
            DiscountApply::create([
              'order_id' => $id,
              'discount_id' => $discount->id,
            ]);
        } else {
          $totalPrice += $price;
        }
      }
    }

    $customerDiscount = Discount::whereHas('customerDiscount', function (Builder $query) {
      $query->where('point', '<=', auth()->user()->points);
    })->orderBy('discount', 'desc')->first();

    if ($customerDiscount) {
      $totalDiscount += round($totalPrice * $customerDiscount->discount / 100.0, 2);
      $totalPrice = round($totalPrice * (100.0 - $customerDiscount->discount) / 100.0, 2);

      DiscountApply::create([
        'order_id' => $id,
        'discount_id' => $customerDiscount->id,
      ]);
    }

    $referrerDiscount = Discount::whereHas('referrerDiscount', function (Builder $query) {
      $query->where('number_of_people', '<=', User::where('referrer_id', auth()->id())->count());
    })->orderBy('discount', 'desc')->first();

    if ($referrerDiscount) {
      $totalDiscount += round($totalPrice * $referrerDiscount->discount / 100.0, 2);
      $totalPrice = round($totalPrice * (100.0 - $referrerDiscount->discount) / 100.0, 2);

      DiscountApply::create([
        'order_id' => $id,
        'discount_id' => $referrerDiscount->id,
      ]);
    }

    Order::where([
      ['id', '=', $id]
    ])->update([
      'total_price' => $totalPrice,
      'total_discount' => $totalDiscount,
    ]);
  });

  return true;
}
