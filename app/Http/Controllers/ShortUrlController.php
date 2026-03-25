<?php

namespace App\Http\Controllers;

use App\DTOs\ShortUrlData;
use App\Enums\UserRole;
use App\Http\Requests\ShortUrls\StoreShortUrlRequest;
use App\Models\ShortUrl;
use App\Models\User;
use App\Services\ShortUrlService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ShortUrlController extends Controller
{
    public function __construct(
        protected ShortUrlService $shortUrlService
    ) {}

    public function index(): Response
    {
        $this->authorize('viewAny', ShortUrl::class);

        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('ShortUrls/Index', [
            'shortUrls' => $this->shortUrlService->getShortUrlsForUser($user),
            'canCreate' => $user->role !== UserRole::SuperAdmin,
        ]);
    }

    public function store(StoreShortUrlRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->shortUrlService->createShortUrl(
            $user,
            ShortUrlData::fromRequest($request)
        );

        return to_route('short-urls.index')->with('success', 'Short URL created successfully.');
    }

    public function destroy(ShortUrl $shortUrl): RedirectResponse
    {
        $this->authorize('delete', $shortUrl);

        $this->shortUrlService->deleteShortUrl($shortUrl);

        return to_route('short-urls.index')->with('success', 'Short URL deleted.');
    }

    public function redirect(string $code): RedirectResponse
    {
        $shortUrl = $this->shortUrlService->handleRedirect($code);

        return redirect()->away($shortUrl->original_url);
    }
}
