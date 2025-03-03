<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDetailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $OrderDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($OrderDetails,$order_id)
    {
        //
        $this->OrderDetails = $OrderDetails;
        $this->order_id = $order_id;
    }

    public function build()
    {
        return $this->subject('User Order Details')
                    ->view('userOrderDetails')
                    ->with([
                        'OrderDetails' => $this->OrderDetails,
                        'order_id' => $this->order_id,
                    ]);
    }
    
    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Order Detail Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
