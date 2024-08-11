<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Controller
{
    public function deleteCustomer($customerID)
    {
        DB::transaction(function () use ($customerID) {
            $customer = User::find($customerID);
            $customer->delete();
        });
    }

    public function getTotalCustomers($search)
    {
        if (!$search)
            $search = '';
        else
            $search = trim($search);
        return User::where('is_admin', false)
            ->where([
                ['name', 'ilike', '%' . $search . '%', 'or'],
                ['email', 'ilike', '%' . $search . '%', 'or']
            ])
            ->count();
        // return User::where('is_admin', false)->count();
    }

    public function getCustomers($search, $limit, $offset)
    {
        if (!$search)
            $search = '';
        else
            $search = trim($search);
        return User::where('is_admin', false)
            ->where([
                ['name', 'ilike', '%' . $search . '%', 'or'],
                ['email', 'ilike', '%' . $search . '%', 'or']
            ])
            ->limit($limit)
            ->offset($offset * $limit)
            ->orderBy('points', 'desc')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getCustomer($customerID)
    {
        return User::find($customerID);
    }

    public function updateEmail($customerID, $email)
    {
        DB::transaction(
            function () use ($customerID, $email) {
                $customer = User::find($customerID);
                if ($customer->email != $email) {
                    $customer->email_verified_at = null;
                }
                $customer->email = $email;
                $customer->save();
            }
        );
    }

    public function updatePassword($customerID, $password)
    {
        DB::transaction(function () use ($customerID, $password) {
            $customer = User::find($customerID);
            $customer->password = Hash::make($password);
            $customer->save();

            DB::table('sessions')->where('user_id', $customerID)->delete();
        });
    }

    public function getDiscountInfo($customerID)
    {
        $customer = User::find($customerID);
        $points = $customer->points;

        $customerDiscount = Discount::whereHas('customerDiscount', function (Builder $query) use ($customer) {
            $query->where('point', '<=', $customer->points);
        })->orderBy('discount', 'desc')->first();

        if ($customerDiscount)
            $customerDiscount = $customerDiscount->discount;
        else
            $customerDiscount = 0;

        $referredNumber = User::where('referrer_id', $customerID)->count();

        $referrerDiscount = Discount::whereHas('referrerDiscount', function (Builder $query) use ($customerID) {
            $query->where('number_of_people', '<=', User::where('referrer_id', $customerID)->count());
        })->orderBy('discount', 'desc')->first();

        if ($referrerDiscount)
            $referrerDiscount = $referrerDiscount->discount;
        else
            $referrerDiscount = 0;

        return [$points, $customerDiscount, $referredNumber, $referrerDiscount];
    }

    public function getOrders($customerID, $searchCode, $searchDate)
    {
        $conditions = [
            ['customer_id', '=', $customerID],
            ['status', '=', true],
        ];

        if ($searchCode) {
            $searchCode = str_replace('-', '', $searchCode);
            $searchCode = str_replace(' ', '', $searchCode);
            $conditions[] = ['code', 'ilike', '%' . $searchCode . '%'];
        }

        if ($searchDate)
            $orders = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where($conditions)->whereDate('updated_at', '=', $searchDate)->orderBy('updated_at', 'desc')->orderBy('total_price', 'desc')->orderBy('total_discount', 'desc')->get();
        else
            $orders = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where($conditions)->orderBy('updated_at', 'desc')->orderBy('total_price', 'desc')->orderBy('total_discount', 'desc')->get();

        foreach ($orders as $order) {
            $order->books = [];
            $temp = [];

            if ($order->physicalOrder) {
                $books = $order->physicalOrder->physicalCopies;

                foreach ($books as $book) {
                    if (!in_array($book->id, $temp)) {
                        $temp[] = $book->id;
                    }
                }
            }

            if ($order->fileOrder) {
                $books = $order->fileOrder->fileCopies;

                foreach ($books as $book) {
                    if (!in_array($book->id, $temp)) {
                        $temp[] = $book->id;
                    }
                }
            }

            $books = [];
            foreach ($temp as $elem) {
                $refinedData = refineBookData(Book::withTrashed()->find($elem));
                $books[] = ['name' => $refinedData->name, 'edition' => $refinedData->edition, "id" => $refinedData->id];
            }
            usort($books, function ($a, $b) {
                return strcmp($a['name'], $b['name']) ?: strcmp($a['edition'], $b['edition']);
            });

            $order->books = $books;
        }

        return $orders;
    }

    public function getOrderDetail($id)
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->find($id);

        if (!$order)
            return null;

        $physicalTemp = [];
        if ($order->physicalOrder) {
            $books = $order->physicalOrder->physicalCopies;

            foreach ($books as $book) {
                if (!in_array($book->id, $physicalTemp)) {
                    $physicalTemp[] = $book->id;
                }
            }
        }

        $fileTemp = [];
        if ($order->fileOrder) {
            $books = $order->fileOrder->fileCopies;

            foreach ($books as $book) {
                if (!in_array($book->id, $fileTemp)) {
                    $fileTemp[] = $book->id;
                }
            }
        }

        // $physicalBooks = [];
        // foreach ($physicalTemp as $elem) {
        //     $physicalBooks[] = refineBookData(Book::find($elem));
        // }

        // // Order by name and edition
        // $physicalBooks = collect($physicalBooks)->sortBy('name')->sortBy('edition')->values()->all();
        $physicalBooks = Book::whereIn('id', $physicalTemp)->withTrashed()->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($physicalBooks as &$book) {
            refineBookData($book);
        }

        // $fileBooks = [];
        // foreach ($fileTemp as $elem) {
        //     $fileBooks[] = refineBookData(Book::find($elem), false);
        // }

        // // Order by name and edition
        // $fileBooks = collect($fileBooks)->sortBy('name')->sortBy('edition')->values()->all();
        $fileBooks = Book::whereIn('id', $fileTemp)->withTrashed()->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($fileBooks as &$book) {
            refineBookData($book, false);
        }

        $order->hardCovers = $physicalBooks;
        $order->eBooks = $fileBooks;

        return $order;
    }

    public function show()
    {
        return view('admin.manage.customer.index');
    }
}
