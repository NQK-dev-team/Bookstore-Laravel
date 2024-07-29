<?php

namespace App\Mail;

use App\Http\Controllers\Customer\Profile\ProfileController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

class PurchaseOrder extends Mailable
{
    use Queueable;
    //,SerializesModels; // This will remove relationship data from the model so no need to use it

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(public $orderID)
    {
        $this->order = (new ProfileController())->getOrderDetail($orderID);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'mail.purchase-order',
            with: ['orderDetail' => $this->order],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
