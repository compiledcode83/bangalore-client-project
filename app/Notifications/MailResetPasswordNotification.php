<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = url( "/reset-password/".$this->token );
        $settingEmail = Setting::all();
        $expireIn = config('auth.passwords.users.expire') / 60;
        return ( new MailMessage )
            ->subject( 'Reset Password Notification' )
            ->line( "Hello! You are receiving this email because we received a password reset request for your account." )
            ->action( 'Reset Password', $link )
            ->line( "This password reset link will expire in ".$expireIn." hours" )
            ->line( "If you did not request a password reset, no further action is required." )
            ->from($settingEmail->first()->email)
            ->view( "emails.resetPassword", compact('link') );
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
