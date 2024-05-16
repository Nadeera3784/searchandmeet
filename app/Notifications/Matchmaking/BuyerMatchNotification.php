<?php

namespace App\Notifications\Matchmaking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $match;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($match)
    {
        $this->match = $match;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Curated suppliers for you')
                    ->view('email.matchmaking.buyer_suggestions', [
                        'notifiable' => $notifiable,
                        'match' => $this->match,
                    ]);
    }
}
