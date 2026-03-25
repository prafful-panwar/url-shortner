<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows an admin to create a short url', function (): void {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)
        ->post(route('short-urls.store'), [
            'original_url' => 'https://example.com/some/long/url',
        ]);

    $response->assertRedirect(route('short-urls.index'));
    $this->assertDatabaseHas('short_urls', [
        'user_id' => $admin->id,
        'company_id' => $admin->company_id,
        'original_url' => 'https://example.com/some/long/url',
    ]);
});

it('allows a member to create a short url', function (): void {
    $member = User::factory()->member()->create();

    $response = $this->actingAs($member)
        ->post(route('short-urls.store'), [
            'original_url' => 'https://example.com/another/url',
        ]);

    $response->assertRedirect(route('short-urls.index'));
    $this->assertDatabaseHas('short_urls', [
        'user_id' => $member->id,
        'original_url' => 'https://example.com/another/url',
    ]);
});

it('forbids a superadmin from creating a short url', function (): void {
    $superAdmin = User::factory()->superAdmin()->create();

    $response = $this->actingAs($superAdmin)
        ->post(route('short-urls.store'), [
            'original_url' => 'https://example.com/forbidden',
        ]);

    $response->assertForbidden();
    $this->assertDatabaseMissing('short_urls', [
        'original_url' => 'https://example.com/forbidden',
    ]);
});

it('rejects creation without a valid url', function (): void {
    $member = User::factory()->member()->create();

    $response = $this->actingAs($member)
        ->post(route('short-urls.store'), [
            'original_url' => 'not-a-valid-url',
        ]);

    $response->assertSessionHasErrors('original_url');
});
