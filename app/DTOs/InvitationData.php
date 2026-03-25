<?php

namespace App\DTOs;

use App\Enums\UserRole;
use App\Http\Requests\Invitations\StoreInvitationRequest;

readonly class InvitationData
{
    public function __construct(
        public string $email,
        public UserRole $role,
        public ?string $companyName = null,
    ) {}

    public static function fromRequest(StoreInvitationRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            role: UserRole::from($request->validated('role')),
            companyName: $request->validated('company_name'),
        );
    }
}
