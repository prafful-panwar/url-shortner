<?php

namespace App\Models;

use Database\Factories\ShortUrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortUrl extends Model
{
    /** @use HasFactory<ShortUrlFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'original_url',
        'short_code',
        'visits',
    ];

    protected function casts(): array
    {
        return [
            'visits' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
