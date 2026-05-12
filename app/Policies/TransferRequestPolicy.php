<?php

namespace App\Policies;

use App\Models\TransferRequest;
use App\Models\User;

class TransferRequestPolicy
{
    /**
     * Determine if the user can view the transfer request.
     */
    public function view(User $user, TransferRequest $transferRequest): bool
    {
        return $user->employer_id === $transferRequest->current_employer_id ||
               $user->employer_id === $transferRequest->requesting_employer_id;
    }

    /**
     * Determine if the user can approve the transfer request.
     */
    public function approve(User $user, TransferRequest $transferRequest): bool
    {
        return $user->employer_id === $transferRequest->current_employer_id &&
               $transferRequest->status === 'pending';
    }

    /**
     * Determine if the user can reject the transfer request.
     */
    public function reject(User $user, TransferRequest $transferRequest): bool
    {
        return $user->employer_id === $transferRequest->current_employer_id &&
               $transferRequest->status === 'pending';
    }

    /**
     * Determine if the user can cancel the transfer request.
     */
    public function cancel(User $user, TransferRequest $transferRequest): bool
    {
        return $user->employer_id === $transferRequest->requesting_employer_id &&
               $transferRequest->status === 'pending';
    }

    /**
     * Determine if the user can view all transfer requests.
     */
    public function viewTransfers(User $user): bool
    {
        return $user->employer_id !== null;
    }
}