<?php

namespace App\Notifications;

use App\Models\AnnualFinancialOverview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class NewAnnualFinancialOverviewNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\AnnualFinancialOverview
     */
    private $annualFinancialOverview;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\AnnualFinancialOverview $annualFinancialOverview
     * @return void
     */
    public function __construct(AnnualFinancialOverview $annualFinancialOverview)
    {
        $this->annualFinancialOverview = $annualFinancialOverview;
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

        $documentName = pathinfo($this->annualFinancialOverview->original_file_name, PATHINFO_FILENAME);

        return (new MailMessage)
            ->subject('Uw '.$documentName.' staat klaar.')
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('Uw '.$documentName.' staat klaar.')
            ->line('Ga naar het portaal om het document te bekijken.')
            ->action('Bekijk hier uw document', $url)
            ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'))
            ->attach(Storage::path($this->annualFinancialOverview->storage_path), [
                'as' => $this->annualFinancialOverview->original_file_name
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
