<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Document;

class AgreementSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Document $document)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation: Loan Agreement Signed - BotsLMS')
            ->greeting('Hello ' . $this->document->documentable->customer->first_name . ',')
            ->line('Thank you for signing your loan agreement.')
            ->line('A copy of the signed agreement is now available in your records.')
            ->action('View Loan Details', route('loans.show', $this->document->documentable_id))
            ->line('If you need a printed copy, you can download it from your dashboard.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'loan_id' => $this->document->documentable_id,
            'signed_at' => $this->document->signed_at,
        ];
    }
}
