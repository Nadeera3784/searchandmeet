<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingRequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;
    private $meetingRequest;

    public function __construct($meetingRequest)
    {
        $this->meetingRequest = $meetingRequest;
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
                    ->subject('Your meeting request has been submitted!')
                    ->view('email.meetingRequest.submitted', [
                        'notifiable' => $notifiable,
                        'meeting_request' => $this->meetingRequest,
                        'route' => route('purchase_requirements.search')
                    ]);
    }
}
