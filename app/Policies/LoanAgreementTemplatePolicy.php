<?php

namespace App\Policies;

use App\Models\LoanAgreementTemplate;
use App\Models\User;

class LoanAgreementTemplatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'Superadmin' || $user->user_type === 'Employee';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LoanAgreementTemplate $loanAgreementTemplate): bool
    {
        return $user->user_type === 'Superadmin' || $user->user_type === 'Employee';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LoanAgreementTemplate $loanAgreementTemplate): bool
    {
        return $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LoanAgreementTemplate $loanAgreementTemplate): bool
    {
        return $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LoanAgreementTemplate $loanAgreementTemplate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LoanAgreementTemplate $loanAgreementTemplate): bool
    {
        return false;
    }
}
