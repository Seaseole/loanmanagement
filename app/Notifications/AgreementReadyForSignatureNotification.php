<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Document;
use Illuminate\Support\Facades\URL;

class AgreementReadyForSignatureNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Document $document)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $signingUrl = URL::temporarySignedRoute(
            'signature.show',
            now()->addDays(7),
            ['document' => $this->document->id]
        );

        return (new MailMessage)
            ->subject('Action Required: Sign Your Loan Agreement - BotsLMS')
            ->greeting('Hello ' . $this->document->documentable->customer->first_name . ',')
            ->line('Your loan agreement is ready for your signature.')
            ->line('Please click the button below to review and sign the document on your device.')
            ->action('Sign Agreement', $signingUrl)
            ->line('This link will expire in 7 days.')
            ->line('If you have any questions, please contact our support team.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'loan_id' => $this->document->documentable_id,
        ];
    }
}
