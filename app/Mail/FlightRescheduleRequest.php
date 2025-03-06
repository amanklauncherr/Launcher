<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FlightRescheduleRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    /**
     * Create a new message instance.
     */
    public function __construct($message)
    {
        $this->message=$message;
    }

    public function build()
    {
        return $this->subject('Flight Reschedule Request')
        ->view('FlightRescheduleRequest')
        ->with([
            'name' => $this->message
        ]);
    }


    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Admin Cancel Order Mail',
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
