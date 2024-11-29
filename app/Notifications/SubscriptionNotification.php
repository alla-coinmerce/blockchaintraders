<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class SubscriptionNotification extends Notification
{
    use Queueable;

     /**
     * @var string subscriptionType
     */
    private $subscriptionType;

    /**
     * Create a new notification instance.
     *
     * @param string $subscriptionType
     * @return void
     */
    public function __construct(string $subscriptionType)
    {
        $this->subscriptionType = $subscriptionType;
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
        $url = route('login');

        return (new MailMessage)
            ->subject('Abonnement BlockchainTraders Kennisbank')
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('Bedankt voor het abonneren op de BlockchainTraders Kennisbank.')
            ->line('Klik op onderstaande link om naar de kennisbank te gaan .')
            ->action('Naar kennisbank', $url)
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
