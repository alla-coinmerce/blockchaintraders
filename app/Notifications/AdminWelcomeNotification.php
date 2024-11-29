<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class AdminWelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct()
    {
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
        $validUntil = Carbon::now()->addDays(3);

        $notifiable->welcome_valid_until = $validUntil; 
        
        $notifiable->save();

        $url = URL::temporarySignedRoute(
            'admin.verifyAccount',
            $validUntil, 
            [
                'user' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]);

        return (new MailMessage)
                    ->subject('BlockchainTraders: Welkom')
                    ->greeting('Beste '.$notifiable->firstname.',')
                    ->line('Je bent toegevoegd als administrator.')
                    ->line('Klik op onderstaande link om het wachtwoord voor je account in te stellen.')
                    ->action('Activeer je account', $url)
                    ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'));
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
            //
        ];
    }
}
