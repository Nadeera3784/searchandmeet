<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRecieved extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $order_item;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $order_item)
    {
        $this->order = $order;
        $this->order_item = $order_item;
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
                ->subject('New order received')
                ->view('email.order.received', [
                    'notifiable' => $notifiable,
                    'order_item' => $this->order_item,
                    'route' => route('person.orders.show', $this->order->getRouteKey())
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
            'order' => $this->order,
        ];
    }
}
