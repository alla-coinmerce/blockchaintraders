<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class SubscriptionWelcomeUserNotification extends Notification
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
        $validUntil = Carbon::now()->addDays(3);

        $notifiable->welcome_valid_until = $validUntil; 
        
        $notifiable->save();

        $url = URL::temporarySignedRoute(
            'verifyAccount',
            $validUntil, 
            [
                'user' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]);

        return (new MailMessage)
            ->subject('Abonnement BlockchainTraders Kennisbank')
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('We hebben uw abonnement op de BlockchainTraders Kennisbank verwerkt en een account voor u klaargezet.')
            ->line('Klik op onderstaande link om het wachtwoord voor uw account in te stellen.')
            ->action('Activeer account', $url)
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
