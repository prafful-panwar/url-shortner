<?php

namespace App\Http\Requests\Invitations;

use App\Enums\UserRole;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->can('create', Invitation::class);
    }

    /**
        /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->user();
        $allowedRoles = $user->role->getAllowedRolesToInvite();

        return [
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', Rule::in($allowedRoles)],
            'company_name' => [
                'nullable',
                Rule::requiredIf(fn (): bool => $user->isSuperAdmin() && $this->input('role') === UserRole::Admin->value),
                'string',
                'max:255',
            ],
        ];
    }
}
