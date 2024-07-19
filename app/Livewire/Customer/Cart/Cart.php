<?php

namespace App\Livewire\Customer\Cart;

use Livewire\Component;
use App\Models\PhyiscalCopy;
use App\Http\Controllers\Customer\Cart\CartController;

class Cart extends Component
{
    private $controller;
    public $loyalty;
    public $refer;
    public $cartDetail;

    public function __construct()
    {
        $this->controller = new CartController();
    }

    public function getPersonalDiscount()
    {
        [$this->loyalty, $this->refer] = $this->controller->getPersonalDiscount();
    }

    public function getCartDetail()
    {
        $this->cartDetail = $this->controller->getCartDetail();
    }

    public function updateCart()
    {
        $this->controller->updateCart();
    }

    public function updateAddress()
    {
    }

    public function getBookStock($id)
    {
        $result = PhyiscalCopy::find($id);
        return $result ? $result->quantity : 0;
    }

    public function updateAmount($id, $amount)
    {
    }

    public function render()
    {
        $this->getPersonalDiscount();
        $this->getCartDetail();
        return view('livewire.customer.cart.cart');
    }
}
