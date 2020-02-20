<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrintImagesConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $items;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->items = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Print Confirmation -- Mail from ITC-PROMOTIONS.com')
            ->view('emails.printConfirmation');
    }
}
