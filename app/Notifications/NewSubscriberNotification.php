<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewSubscriberNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\User $user
     */
    private $user;

    /**
     * @var string subscriptionType
     */
    private $subscriptionType;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     * @param string $subscriptionType
     * @return void
     */
    public function __construct(User $user, string $subscriptionType)
    {
        $this->user = $user;
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
        $url = url(config('app.admin_url').'/users');

        return (new MailMessage)
                    ->subject('BlockchainTraders: Nieuw abonnement kennisbank')
                    ->greeting('Hallo '.$notifiable->firstname.',')
                    ->line($this->user->firstname.' '.$this->user->lastname.' heeft een '.__($this->subscriptionType).' abonnement genomen op de kennisbank.')
                    ->action('Bekijk de nieuwe inschrijving', $url)
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
