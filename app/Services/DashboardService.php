<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\ShortUrl;
use App\Models\User;

class DashboardService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function getStatsForUser(User $user): array
    {
        return match (true) {
            $user->isSuperAdmin() => $this->getSuperAdminStats(),
            $user->isAdmin() => $this->getAdminStats($user),
            default => $this->getMemberStats($user),
        };
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getSuperAdminStats(): array
    {
        return [
            [
                'label' => 'Total Companies',
                'value' => Company::query()->count(),
                'icon' => 'BuildingOfficeIcon',
            ],
            [
                'label' => 'Total Users',
                'value' => User::query()->count(),
                'icon' => 'UsersIcon',
            ],
            [
                'label' => 'Total Short URLs',
                'value' => ShortUrl::query()->count(),
                'icon' => 'LinkIcon',
            ],
            [
                'label' => 'Total Visits',
                'value' => (int) ShortUrl::query()->sum('visits'),
                'icon' => 'CursorArrowRaysIcon',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getAdminStats(User $user): array
    {
        return [
            [
                'label' => 'Company Users',
                'value' => User::query()->where('company_id', $user->company_id)->count(),
                'icon' => 'UsersIcon',
            ],
            [
                'label' => 'Pending Invitations',
                'value' => Invitation::query()->where('company_id', $user->company_id)->whereNull('accepted_at')->count(),
                'icon' => 'EnvelopeIcon',
            ],
            [
                'label' => 'Company URLs',
                'value' => ShortUrl::query()->where('company_id', $user->company_id)->count(),
                'icon' => 'LinkIcon',
            ],
            [
                'label' => 'Total Company Visits',
                'value' => (int) ShortUrl::query()->where('company_id', $user->company_id)->sum('visits'),
                'icon' => 'CursorArrowRaysIcon',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getMemberStats(User $user): array
    {
        return [
            [
                'label' => 'My Short URLs',
                'value' => ShortUrl::query()->where('user_id', $user->id)->count(),
                'icon' => 'LinkIcon',
            ],
            [
                'label' => 'My Total Visits',
                'value' => (int) ShortUrl::query()->where('user_id', $user->id)->sum('visits'),
                'icon' => 'CursorArrowRaysIcon',
            ],
            [
                'label' => 'Company URLs',
                'value' => ShortUrl::query()->where('company_id', $user->company_id)->count(),
                'icon' => 'BuildingOfficeIcon',
            ],
        ];
    }
}
