<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin || $user->role === UserRole::Member;
    }

    public function view(User $user, ShortUrl $shortUrl): bool
    {
        return match ($user->role) {
            UserRole::SuperAdmin => true,
            UserRole::Admin => $shortUrl->company_id === $user->company_id,
            UserRole::Member => $shortUrl->user_id === $user->id,
        };
    }

    public function update(User $user, ShortUrl $shortUrl): bool
    {
        return match ($user->role) {
            UserRole::SuperAdmin => false,
            UserRole::Admin => $shortUrl->company_id === $user->company_id,
            UserRole::Member => $shortUrl->user_id === $user->id,
        };
    }

    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        return match ($user->role) {
            UserRole::SuperAdmin => false,
            UserRole::Admin => $shortUrl->company_id === $user->company_id,
            UserRole::Member => $shortUrl->user_id === $user->id,
        };
    }
}
