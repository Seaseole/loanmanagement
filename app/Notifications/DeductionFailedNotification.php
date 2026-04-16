<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Transaction;

class DeductionFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Transaction $transaction)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject('Repayment Deduction Failed - BotsLMS')
            ->greeting('Hello ' . $this->transaction->loan->customer->first_name . ',')
            ->line('A repayment deduction of P' . number_format($this->transaction->amount, 2) . ' from your account has failed.')
            ->line('Reason: ' . ($this->transaction->gateway_response['message'] ?? 'Unknown gateway error'))
            ->line('Please ensure you have sufficient funds to avoid delinquency.')
            ->action('View Repayment Schedule', route('loans.show', $this->transaction->loan))
            ->line('If you have any questions, please contact our support team.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'loan_id' => $this->transaction->loan_id,
            'amount' => $this->transaction->amount,
            'message' => 'A repayment deduction has failed.',
        ];
    }
}
