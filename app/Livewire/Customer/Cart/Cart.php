<?php

namespace App\Livewire\Customer\Cart;

use App\Http\Controllers\Customer\Cart\CartController;
use Livewire\Component;

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

    public function render()
    {
        $this->getPersonalDiscount();
        $this->getCartDetail();
        return view('livewire.customer.cart.cart');
    }
}
