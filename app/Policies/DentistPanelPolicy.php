<?php

namespace App\Policies;

use App\Models\User;

class DentistPanelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user): bool
    {
        $user = auth()->user();
        $dentist = $user->dentist;

        return true;
    }
}
