<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Member = 'member';

    /**
     * @return list<string>
     */
    public function getAllowedRolesToInvite(): array
    {
        return match ($this) {
            self::SuperAdmin => [self::Admin->value],
            self::Admin => [self::Admin->value, self::Member->value],
            self::Member => [],
        };
    }
}
