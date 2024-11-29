<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Laravel\Cashier\Order\Order;

class OrderPaymentFailedNotification extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('BlockchainTraders betaling abonnement mislukt')
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('Helaas is de betaling voor uw abonnement mislukt. Daarom verzoeken wij u vriendelijk uw betaalmethode te updaten.')
            ->action('Update betaalmethode', route('my-account'))
            ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
