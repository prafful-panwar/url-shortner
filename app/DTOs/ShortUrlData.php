<?php

namespace App\DTOs;

use App\Http\Requests\ShortUrls\StoreShortUrlRequest;

readonly class ShortUrlData
{
    public function __construct(
        public string $originalUrl,
    ) {}

    public static function fromRequest(StoreShortUrlRequest $request): self
    {
        return new self(
            originalUrl: $request->validated('original_url'),
        );
    }
}
