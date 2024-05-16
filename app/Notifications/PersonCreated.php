<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonCreated extends Notification implements ShouldQueue
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
                    ->subject('Welcome! Let\'s get started')
                    ->view('email.person.created', [
                        'notifiable' => $notifiable,
                        'route' => route('person.account.setup.show', ['token' => $this->setupToken])
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
