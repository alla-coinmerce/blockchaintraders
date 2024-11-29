<?php

namespace App\Notifications;

use App\Models\PendingRegistration;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\PendingRegistration $pendingRegistration
     */
    private $pendingRegistration;

    /**
     * @var \Barryvdh\DomPDF\PDF
     */
    private $pdf;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\PendingRegistration $pendingRegistration
     * @return void
     */
    public function __construct(PendingRegistration $pendingRegistration, PDF $pdf)
    {
        $this->pendingRegistration = $pendingRegistration;
        $this->pdf = $pdf;
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
        $url = url(config('app.admin_url').'/users');

        $mailMessage = (new MailMessage)
                    ->subject('BlockchainTraders: Nieuwe inschrijving')
                    ->greeting('Hallo '.$notifiable->firstname.',')
                    ->line($this->pendingRegistration->user->firstname.' '.$this->pendingRegistration->user->lastname.' heeft zich ingeschreven via het inschrijfformulier op de website.')
                    ->action('Bekijk de nieuwe inschrijving', $url)
                    ->salutation(new HtmlString('Met vriendelijke groet,<br>Team BlockchainTraders'));
         
        $mailMessage->attachData($this->pdf->output(), 'Inschrijfbevestiging.pdf', [
            'mime' => 'application/pdf',
        ]);

        if($this->pendingRegistration->identificationDocument)
        {
            $mailMessage->attach(Storage::path($this->pendingRegistration->identificationDocument->storage_path), [
                'as' => $this->pendingRegistration->identificationDocument->original_file_name
            ]);
        }

        if($this->pendingRegistration->bankStatementDocument)
        {
            $mailMessage->attach(Storage::path($this->pendingRegistration->bankStatementDocument->storage_path), [
                'as' => $this->pendingRegistration->bankStatementDocument->original_file_name
            ]);
        }

        if($this->pendingRegistration->cocExtractDocument)
        {
            $mailMessage->attach(Storage::path($this->pendingRegistration->cocExtractDocument->storage_path), [
                'as' => $this->pendingRegistration->cocExtractDocument->original_file_name
            ]);
        }

        return $mailMessage;
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
