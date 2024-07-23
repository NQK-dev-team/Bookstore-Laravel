<?php

namespace App\Livewire\Customer\Cart;

use Livewire\Component;
use App\Models\PhyiscalCopy;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Customer\Cart\CartController;

class Cart extends Component
{
    private $controller;
    public $loyalty;
    public $refer;
    public $cartDetail;
    public $deleteID;
    public $deleteMode;
    public $stopPolling;

    public function __construct()
    {
        $this->controller = new CartController();
        $this->stopPolling = false;
    }

    public function toggleStopPolling()
    {
        $this->stopPolling = !$this->stopPolling;
    }

    #[Renderless]
    public function setDeleteID($id, $mode)
    {
        $this->deleteID = $id;
        $this->deleteMode = $mode;
    }

    public function deleteBook()
    {
        $this->controller->deleteBook($this->deleteID, $this->deleteMode);
    }

    public function updateAddress($address)
    {
        Validator::make(['address' => $address], [
            'address' => 'required|string|max:1000',
        ])->validate();

        $this->controller->updateAddress($address);
    }

    public function getBookStock($id)
    {
        $result = PhyiscalCopy::find($id);
        return $result ? $result->quantity : 0;
    }

    public function updateAmount($id, $amount)
    {
        $stock = $this->getBookStock($id);
        Validator::make(["{$id}_amount" => $amount], [
            "{$id}_amount" => "required|numeric|gte:1|lte:{$stock}",
        ], [
            "{$id}_amount.gte" => "The book amount must be at least 1.",
            "{$id}_amount.lte" => "The book amount must be at most {$stock}.",
            "{$id}_amount.required" => "The book amount must have a value.",
            "{$id}_amount.numeric" => "The book amount must be a numerical value.",
        ])->validate();

        $this->controller->updateAmount($id, $amount);
    }

    public function purchase()
    {
        $data = [];
        $rules = [];
        $message = [];

        $data["address"] = $this->controller->getCurrentAddress();
        $rules["address"] = "required|string|max:1000";

        foreach ($this->cartDetail->physicalOrder->physicalCopies as $book) {
            $id = $book->id;
            $stock = $this->getBookStock($id);
            $amount = $this->cartDetail->physicalOrder->physicalCopies->find($id)->pivot->amount;

            $data["{$id}_amount"] = $amount;
            $rules["{$id}_amount"] = "required|numeric|gte:1|lte:{$stock}";
            $message["{$id}_amount.gte"] = "The book amount must be at least 1.";
            $message["{$id}_amount.lte"] = "The book amount must be at most {$stock}.";
            $message["{$id}_amount.required"] = "The book amount must have a value.";
            $message["{$id}_amount.numeric"] = "The book amount must be a numerical value.";
        }

        Validator::make($data, $rules, $message)->validate();

        $this->controller->purchase();
    }

    public function render()
    {
        $this->controller->updateCart();
        [$this->loyalty, $this->refer] = $this->controller->getPersonalDiscount();
        $this->cartDetail = $this->controller->getCartDetail();
        return view('livewire.customer.cart.cart');
    }
}
