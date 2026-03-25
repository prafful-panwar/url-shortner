<?php

namespace App\Http\Controllers;

use App\Services\WelcomeService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function __construct(
        protected WelcomeService $welcomeService
    ) {}

    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => false,
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'globalStats' => $this->welcomeService->getGlobalStats(),
        ]);
    }
}
