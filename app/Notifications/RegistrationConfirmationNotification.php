<?php

namespace App\Notifications;

use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class RegistrationConfirmationNotification extends Notification
{
    use Queueable;

    /**
     * @var \Barryvdh\DomPDF\PDF
     */
    private $pdf;

    /**
     * Create a new notification instance.
     *
     * @param \Barryvdh\DomPDF\PDF $pdf
     * @return void
     */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
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
            ->subject('BlockchainTraders Inschrijfbevestiging')
            ->greeting('Beste '.$notifiable->firstname.',')
            ->line('We hebben uw inschrijving in goede orde ontvangen. In de bijlage vindt u een kopie van de door u opgegeven inschrijfgegevens.')
            ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'))
            ->attachData($this->pdf->output(), 'Inschrijfbevestiging.pdf', [
                'mime' => 'application/pdf',
            ]);
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
