<?php

namespace App\Http\Controllers;

use App\DTOs\InvitationData;
use App\DTOs\RegistrationData;
use App\Http\Requests\Invitations\RegisterInvitationRequest;
use App\Http\Requests\Invitations\StoreInvitationRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class InvitationController extends Controller
{
    public function __construct(
        protected InvitationService $invitationService
    ) {}

    public function index(): Response
    {
        $this->authorize('viewAny', Invitation::class);

        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Invitations/Index', [
            'invitations' => $this->invitationService->getInvitationsForUser($user),
            'allowedRoles' => $user->role->getAllowedRolesToInvite(),
        ]);
    }

    public function store(StoreInvitationRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->invitationService->createInvitation(
            $user,
            InvitationData::fromRequest($request)
        );

        return to_route('invitations.index')->with('success', 'Invitation sent successfully.');
    }

    public function accept(string $token): Response
    {
        $invitation = $this->invitationService->getInvitationByToken($token);

        return Inertia::render('Invitations/Accept', [
            'invitation' => $invitation->load('company'),
            'token' => $token,
        ]);
    }

    public function register(RegisterInvitationRequest $request, string $token): RedirectResponse
    {
        $invitation = $this->invitationService->getInvitationByToken($token);

        $user = $this->invitationService->registerFromInvitation(
            $invitation,
            RegistrationData::fromRequest($request)
        );

        Auth::login($user);

        return to_route('dashboard');
    }
}
