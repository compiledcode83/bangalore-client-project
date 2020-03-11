<?php

namespace App\Mail;

use App\Models\Setting;
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
        $adminSettings = Setting::find(1);
        return $this->subject('Printing Confirmation -- ITC-PROMOTIONS.com')
            ->from($adminSettings->email)
            ->view('emails.printConfirmation');
    }
}
