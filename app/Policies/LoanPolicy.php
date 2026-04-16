<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'Employee' || $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
        if ($user->user_type === 'Superadmin') return true;
        if ($user->user_type === 'Employee') return true;
        
        // Customers can only see their own loans
        return $user->user_type === 'Customer' && $user->id === $loan->customer_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Employees (Loan Officers) and Superadmins can create loans
        return $user->user_type === 'Employee' || $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
        return $user->user_type === 'Employee' || $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
        return $user->user_type === 'Superadmin';
    }

    /**
     * Determine whether the user can approve a loan.
     */
    public function approve(User $user, Loan $loan): bool
    {
        return ($user->user_type === 'Employee' || $user->user_type === 'Superadmin') 
            && $loan->loan_status === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Loan $loan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Loan $loan): bool
    {
        return false;
    }
}
