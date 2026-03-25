<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class InvitationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::SuperAdmin || $user->role === UserRole::Admin;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::SuperAdmin || $user->role === UserRole::Admin;
    }

    /**
     * @return list<UserRole>
     */
    public function allowedRolesToInvite(User $user): array
    {
        return match ($user->role) {
            UserRole::SuperAdmin => [UserRole::Admin],
            UserRole::Admin => [UserRole::Admin, UserRole::Member],
            default => [],
        };
    }
}
