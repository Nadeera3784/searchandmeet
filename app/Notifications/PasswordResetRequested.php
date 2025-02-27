<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetRequested extends Notification implements ShouldQueue
{
    use Queueable;

    public $setupToken;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($setupToken)
    {
        $this->setupToken = $setupToken;
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
        return (new MailMessage)
                    ->subject('Password reset')
                    ->greeting('Hello '.$notifiable->name. '!')
                    ->view('email.account.passwordReset', [
                        'notifiable' => $notifiable,
                        'route' =>  route('person.password.reset_view', ['token' => $this->setupToken->token])
                    ]);
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
