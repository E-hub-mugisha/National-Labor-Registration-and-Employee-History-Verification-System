<?php

namespace App\Notifications;

use App\Models\TransferRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferDecided extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public TransferRequest $transferRequest,
        public string $decision
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $action = $this->decision === 'approved' ? 'approved' : 'rejected';
        $actionUrl = route('transfers.show', $this->transferRequest);

        return (new MailMessage)
            ->subject("Transfer Request {$action}")
            ->greeting("Hello {$notifiable->name},")
            ->line("The transfer request for {$this->transferRequest->employee->full_name} has been {$action}.")
            ->action('View Details', $actionUrl)
            ->line('Thank you for using our system.');
    }

    public function toArray($notifiable): array
    {
        return [
            'transfer_request_id' => $this->transferRequest->id,
            'employee_name' => $this->transferRequest->employee->full_name,
            'decision' => $this->decision,
        ];
    }
}