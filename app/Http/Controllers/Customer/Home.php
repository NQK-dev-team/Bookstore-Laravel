<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
    private function getDiscountBooks()
    {
    }

    private function getCategoryBooks($category)
    {
    }

    private function getPublisherBooks($publisher)
    {
    }

    private function getTopCategories()
    {
    }

    private function getTopPubishers()
    {
    }


    public function show()
    {
        return view('customer.index', [
            'discountBooks' => $this->getDiscountBooks()
        ]);
    }
}
