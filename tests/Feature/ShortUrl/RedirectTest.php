<?php

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('it publicly resolves a short url and redirects to the original url', function (): void {
    $shortUrl = ShortUrl::factory()->create([
        'original_url' => 'https://example.com/target',
        'short_code' => 'TEST12',
    ]);

    $response = $this->get(route('short-urls.redirect', ['code' => 'TEST12']));

    $response->assertRedirect('https://example.com/target');
});

it('it increments visit count on redirect', function (): void {
    $shortUrl = ShortUrl::factory()->create([
        'short_code' => 'VISIT1',
        'visits' => 0,
    ]);

    $this->get(route('short-urls.redirect', ['code' => 'VISIT1']));

    $freshUrl = $shortUrl->fresh();

    expect($freshUrl instanceof ShortUrl ? $freshUrl->visits : 0)->toBe(1);
});

it('it returns 404 for a non-existent short code', function (): void {
    $response = $this->get(route('short-urls.redirect', ['code' => 'NONEXIST']));

    $response->assertNotFound();
});

it('it does not require authentication to resolve a short url', function (): void {
    $shortUrl = ShortUrl::factory()->create([
        'short_code' => 'PUBLIC',
    ]);

    // Ensure we are not logged in
    $response = $this->get(route('short-urls.redirect', ['code' => 'PUBLIC']));

    $response->assertRedirect();
});
