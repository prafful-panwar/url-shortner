<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Dashboard', [
            'stats' => $this->dashboardService->getStatsForUser($user),
        ]);
    }
}
