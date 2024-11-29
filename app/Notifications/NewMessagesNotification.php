<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewMessagesNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $url = url(config('app.admin_url').'/messages');

        $unreadMessages = Message::where('read', false)->count();

        $message = $unreadMessages > 1 ? 'berichten' : 'bericht';

        return (new MailMessage)
                    ->subject('BlockchainTraders: Nieuw bericht ontvangen')
                    ->greeting('Hallo '.$notifiable->firstname.',')
                    ->line('Je hebt een nieuw bericht ontvangen.')
                    ->line('Er zijn '.$unreadMessages.' ongelezen '.$message.'.')
                    ->action('Bekijk '.$message, $url)
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
