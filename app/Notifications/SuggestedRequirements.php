<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuggestedRequirements extends Notification implements ShouldQueue
{
    use Queueable;

    public $requirements;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requirements)
    {
        $this->requirements = $requirements;
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


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Post meeting summary')
            ->view('email.report.requirement-suggestions', [
                'notifiable' => $notifiable,
                'requirements' => $this->requirements,
                'route' => route('purchase_requirements.search')
            ]);
    }

}
