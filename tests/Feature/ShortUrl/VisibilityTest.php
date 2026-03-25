<?php

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('it superadmin can see all short urls across all companies', function (): void {
    $superAdmin = User::factory()->superAdmin()->create();
    $companyA = Company::factory()->create();
    $companyB = Company::factory()->create();

    ShortUrl::factory()->create(['company_id' => $companyA->id]);
    ShortUrl::factory()->create(['company_id' => $companyB->id]);

    $response = $this->actingAs($superAdmin)->get(route('short-urls.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('ShortUrls/Index')
        ->has('shortUrls', 2)
    );
});

it('it admin can only see short urls created in their own company', function (): void {
    $company = Company::factory()->create();
    $otherCompany = Company::factory()->create();

    $admin = User::factory()->admin()->create(['company_id' => $company->id]);

    $ownUrl = ShortUrl::factory()->create(['company_id' => $company->id]);
    ShortUrl::factory()->create(['company_id' => $otherCompany->id]);

    $response = $this->actingAs($admin)->get(route('short-urls.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('ShortUrls/Index')
        ->has('shortUrls', 1)
        ->where('shortUrls.0.id', $ownUrl->id)
    );
});

it('it member can only see short urls created by themselves', function (): void {
    $company = Company::factory()->create();
    $member = User::factory()->member()->create(['company_id' => $company->id]);
    $otherMember = User::factory()->member()->create(['company_id' => $company->id]);

    $ownUrl = ShortUrl::factory()->create(['user_id' => $member->id, 'company_id' => $company->id]);
    $otherUrl = ShortUrl::factory()->create(['user_id' => $otherMember->id, 'company_id' => $company->id]);

    $response = $this->actingAs($member)->get(route('short-urls.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('ShortUrls/Index')
        ->has('shortUrls', 1)
        ->where('shortUrls.0.id', $ownUrl->id)
    );
});
