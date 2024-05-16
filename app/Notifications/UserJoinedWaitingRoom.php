<?php

namespace App\Notifications;

use App\Services\DateTime\TimeZoneService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class UserJoinedWaitingRoom extends Notification implements ShouldQueue
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
        if($notifiable->type == 'person' && $notifiable->phone_verified_at)
        {
            return ['mail', TwilioChannel::class];
        }

        return ['mail'];
    }

    public function toTwilio($notifiable)
    {
        $timeZoneService = new TimeZoneService();
        $time = $timeZoneService->localTime($notifiable, $this->meeting->orderItem->timeslot->start, 'D M Y H:i A');

        return (new TwilioSmsMessage())
            ->content("Search meetings alert\nA participant has joined the waiting room for your meeting on $time, Please login to your dashboard to join.");
    }

    /**
     * Get the mail representation of the notification.
     * @param TimeZoneService $timeZoneService
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $timeZoneService = new TimeZoneService();
        $time = $timeZoneService->localTime($notifiable, $this->meeting->orderItem->timeslot->start, 'D M Y H:i A');
        return (new MailMessage)
                    ->subject('You have participants waiting')
                    ->view('email.meeting.personInWaitingRoom', [
                        'notifiable' => $notifiable,
                        'time' => $time,
                        'route' => route('person.meeting.waiting_room', $this->meeting->getRouteKey())
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
