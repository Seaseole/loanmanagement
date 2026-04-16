<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Loan;

class LoanApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Loan $loan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Could add 'sms' channel here
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Loan Approved - BotsLMS')
            ->greeting('Hello ' . $this->loan->customer->first_name . ',')
            ->line('Your loan application for P' . number_format($this->loan->principal_amount, 2) . ' has been approved.')
            ->line('The repayment term is ' . $this->loan->term_months . ' months.')
            ->action('View Loan Details', route('loans.show', $this->loan))
            ->line('Thank you for choosing BotsLMS!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'amount' => $this->loan->principal_amount,
            'message' => 'Your loan has been approved.',
        ];
    }
}
