<?php

namespace App\Notifications;

use App\Repositories\Person\PersonRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class MeetingReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $meeting;
    public $timeaway;
    public $personRepository;

    /**
     * MeetingReminder constructor.
     * @param $meeting
     * @param int $timeaway
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct($meeting, $timeaway = 30)
    {
        $this->meeting = $meeting;
        $this->timeaway = $timeaway;
        $this->personRepository = app()->make(PersonRepositoryInterface::class);
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
        return (new TwilioSmsMessage())
            ->content("Search meetings reminder\nYou have a meeting in $this->timeaway minutes, Please login to your dashboard to check.");
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
            $meetingRoute = $this->personRepository->getDirectLoginLink($notifiable->id, route('person.meeting.waiting_room', ['meeting' =>$this->meeting->getRouteKey()]));
        }

        return (new MailMessage)
                    ->subject('New meeting reminder')
                    ->view('email.meeting.reminder', [
                        'notifiable' => $notifiable,
                        'timeaway' => $this->timeaway,
                        'meeting' => $this->meeting,
                        'route' => $meetingRoute
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
            'timeaway' => $this->timeaway
        ];
    }
}
