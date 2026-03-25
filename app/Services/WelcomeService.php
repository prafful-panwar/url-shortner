<?php

namespace App\Services;

use App\Models\Company;
use App\Models\ShortUrl;

class WelcomeService
{
    /**
     * @return array<string, int>
     */
    public function getGlobalStats(): array
    {
        return [
            'totalUrls' => ShortUrl::query()->count(),
            'totalVisits' => (int) ShortUrl::query()->sum('visits'),
            'totalCompanies' => Company::query()->count(),
        ];
    }
}
