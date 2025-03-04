<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserFlightBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $Pnr, $BookingRef, $pdf_url, $user_mail;
    
    /**
     * Create a new message instance.
    */
    public function __construct($Pnr,$BookingRef,$pdf_url,$user_mail,$BaseFare,$Tax,$TotalAmount)
    {
        $this->Pnr = $Pnr;
        $this->BookingRef = $BookingRef; 
        $this->pdf_url = $pdf_url;
        $this->user_mail = $user_mail;
        $this->BaseFare = $BaseFare;
        $this->Tax = $Tax;
        $this->TotalAmount = $TotalAmount;
    }

    public function build()
    {
        return $this->subject('User Flight Booking')
                    ->view('userFlightBooking')
                    ->with([
                        'Pnr'=>$this->Pnr,
                        'BookingRef'=>$this->BookingRef, 
                        'pdf_url'=>$this->pdf_url,
                        'user_mail' =>$this->$user_mail,
                        'BaseFare'=>$this->$BaseFare,
                        'Tax'=>$this->$Tax,
                        'TotalAmount'=>$this->$TotalAmount,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'User Flight Booking',
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
