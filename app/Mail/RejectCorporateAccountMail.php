<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectCorporateAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $accountName;

    /**
     * Create a new message instance.
     *
     * @param $accountName
     */
    public function __construct($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from ITC-PROMOTIONS.com')
            ->view('emails.accounts.rejectCorporate');
    }
}
