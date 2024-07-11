<?php

use App\Models\Book;
use App\Models\Discount;
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

  if ($removeFilePath)
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
