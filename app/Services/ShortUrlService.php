<?php

namespace App\Services;

use App\DTOs\ShortUrlData;
use App\Enums\UserRole;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use RuntimeException;

class ShortUrlService
{
    /**
     * @return Collection<int, ShortUrl>
     */
    public function getShortUrlsForUser(User $user): Collection
    {
        /** @var Collection<int, ShortUrl> $shortUrls */
        $shortUrls = match ($user->role) {
            UserRole::SuperAdmin => ShortUrl::query()->with('user', 'company')->latest()->get(),
            UserRole::Admin => ShortUrl::query()->with('user', 'company')->where('company_id', $user->company_id)->latest()->get(),
            UserRole::Member => ShortUrl::query()->with('user', 'company')->where('user_id', $user->id)->latest()->get(),
        };

        return $shortUrls;
    }

    public function createShortUrl(User $user, ShortUrlData $data): ShortUrl
    {
        $attempts = 0;
        $maxAttempts = 5;

        while ($attempts < $maxAttempts) {
            try {
                /** @var ShortUrl $shortUrl */
                $shortUrl = ShortUrl::query()->create([
                    'user_id' => $user->id,
                    'company_id' => $user->company_id,
                    'original_url' => $data->originalUrl,
                    'short_code' => Str::random(6),
                ]);

                return $shortUrl;
            } catch (QueryException $e) {
                throw_if(($e->errorInfo[1] ?? null) !== 1062, $e);

                $attempts++;
                throw_if($attempts >= $maxAttempts, $e);
            }
        }

        throw new RuntimeException("Failed to generate a unique short code after {$maxAttempts} attempts.");
    }

    public function deleteShortUrl(ShortUrl $shortUrl): bool
    {
        $deleted = $shortUrl->delete();

        return (bool) $deleted;
    }

    public function handleRedirect(string $code): ShortUrl
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::query()->where('short_code', $code)->firstOrFail();
        $shortUrl->increment('visits');

        return $shortUrl;
    }
}
