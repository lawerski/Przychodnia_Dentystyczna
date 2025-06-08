<?php

namespace App\Policies;

use App\Http\Requests\CreateServiceRequest;
use Illuminate\Auth\Access\Response;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
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
    public function view(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, CreateServiceRequest $request): bool
    {
        if ($user->hasRole('admin')) {
            return true; // Admins can create services
        }

        if ($user->hasRole('dentist')) {
            $dentist = $user->dentist;
            return $request['dentist_id'] == $dentist->id;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        if ($user->hasRole('admin')) {
            return true; // Admins can delete any service
        }
        if (!$user->hasRole('dentist')) {
            return false;
        }
        $dentist = $user->dentist;
        if (!$dentist) {
            // Dentist not found - this should never happen
            return false;
        }
        return $dentist->id === $service->dentist_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        if ($user->hasRole('admin')) {
            return true; // Admins can delete any service
        }
        if (!$user->hasRole('dentist')) {
            return false;
        }
        $dentist = $user->dentist;
        if (!$dentist) {
            // Dentist not found - this should never happen
            return false;
        }
        return $dentist->id === $service->dentist_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return false;
    }
}
