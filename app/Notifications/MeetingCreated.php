<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingCreated extends Notification implements ShouldQueue
{
    use Queueable;
    public $meeting;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $meetingRoute = null;
        if ($notifiable->type === 'user')
        {
            $meetingRoute = route('agent.meeting.waiting_room.show', $this->meeting->getRouteKey());
        }
        else if($notifiable->type === 'person')
        {
            $meetingRoute = route('person.meetings.show', $this->meeting->getRouteKey());
        }

        return (new MailMessage)
                    ->subject('New meeting available')
                    ->view('email.meeting.created', [
                        'notifiable' => $notifiable,
                        'route' => $meetingRoute,
                        'meeting' => $this->meeting
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
            'meeting' => $this->meeting,
        ];
    }
}
