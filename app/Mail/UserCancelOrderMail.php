<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCancelOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $OrderCancel;
    /**
     * Create a new message instance.
     */
    public function __construct($OrderDetails,$order_id,$order_date)
    {
        $this->OrderDetails = $OrderDetails;
        $this->order_id = $order_id;
        $this->order_date = $order_date;
    }

    public function build()
    {
        return $this->subject('User Cancel Order Mail')
        ->view('UserCancelOrderMail')
        ->with([
            'OrderDetails' => $this->OrderDetails,
            'order_id' => $this->order_id,
            'order_date' => $this->order_date,
        ]);
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'User Cancel Order Mail',
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
