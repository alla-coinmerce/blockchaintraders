<?php

namespace App\Notifications;

use App\Models\Factsheet;
use App\Models\Fund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class NewFactsheetNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Fund
     */
    private $fund;

    /**
     * @var \App\Models\Factsheet
     */
    private $factsheet;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Fund $fund, Factsheet $factsheet)
    {
        $this->fund = $fund;
        $this->factsheet = $factsheet;
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
        $url = config('app.portal_url');

        $path = Storage::path($this->factsheet->storage_path);

        return (new MailMessage)
            ->subject('BlockchainTraders: Factsheet '.$this->fund->name)
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('Er staat een nieuwe factsheet klaar in het portaal.')
            ->action('Bekijk hier de factsheet', $url)
            ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'))
            ->attach($path, [
                'as' => $this->factsheet->original_file_name
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
            //
        ];
    }
}
