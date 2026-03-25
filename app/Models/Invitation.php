<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'role',
        'company_id',
        'invited_by',
        'token',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'accepted_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isPending(): bool
    {
        return $this->accepted_at === null;
    }
}
