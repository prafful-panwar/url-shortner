<?php

namespace App\Services;

use App\DTOs\InvitationData;
use App\DTOs\RegistrationData;
use App\Events\InvitationCreated;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationService
{
    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitationsForUser(User $user): Collection
    {
        /** @var Collection<int, Invitation> $invitations */
        $invitations = Invitation::query()
            ->with('company', 'inviter')
            ->when($user->isSuperAdmin(), fn (Builder $q): Builder => $q)
            ->when($user->isAdmin() || $user->isMember(), fn (Builder $q): Builder => $q->where('company_id', $user->company_id))
            ->latest()
            ->get();

        return $invitations;
    }

    public function createInvitation(User $user, InvitationData $data): Invitation
    {
        return DB::transaction(function () use ($user, $data): Invitation {
            if ($user->isSuperAdmin()) {
                /** @var string $companyName */
                $companyName = $data->companyName;
                /** @var Company $company */
                $company = Company::query()->firstOrCreate(['name' => $companyName]);
            } else {
                /** @var Company $company */
                $company = $user->company;
            }

            $invitation = Invitation::query()->updateOrCreate(
                ['email' => $data->email, 'company_id' => $company->id],
                [
                    'role' => $data->role,
                    'invited_by' => $user->id,
                    'token' => Str::random(64),
                    'accepted_at' => null,
                ]
            );

            event(new InvitationCreated($invitation));

            return $invitation;
        });
    }

    public function getInvitationByToken(string $token): Invitation
    {
        /** @var Invitation $invitation */
        $invitation = Invitation::query()
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        return $invitation;
    }

    public function registerFromInvitation(Invitation $invitation, RegistrationData $data): User
    {
        return DB::transaction(function () use ($invitation, $data): User {
            /** @var User $user */
            $user = User::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'role' => $invitation->role,
                'company_id' => $invitation->company_id,
                'email_verified_at' => now(),
            ]);

            $invitation->update(['accepted_at' => now()]);

            return $user;
        });
    }
}
