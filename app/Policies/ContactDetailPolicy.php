<?php

namespace App\Policies;

use App\Models\ContactDetail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContactDetailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContactDetail $contactDetail): bool
    {
        return $user->id == $contactDetail->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContactDetail $contactDetail): bool
    {
        return $this->view($user, $contactDetail);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactDetail $contactDetail): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContactDetail $contactDetail): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContactDetail $contactDetail): bool
    {
        return false;
    }
}
