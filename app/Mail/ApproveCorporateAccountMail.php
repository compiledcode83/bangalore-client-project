<?php

namespace App\Mail;

use App\Models\Setting;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveCorporateAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $accountName;
    public $socialAccounts;

    /**
     * Create a new message instance.
     *
     * @param $accountName
     */
    public function __construct($accountName)
    {
        $this->accountName = $accountName;
        $this->socialAccounts = SocialMedia::all();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from ITC-PROMOTIONS.com')
                    ->view('emails.accounts.approveCorporate');
    }
}
