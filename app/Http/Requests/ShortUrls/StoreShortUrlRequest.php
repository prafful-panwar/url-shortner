<?php

namespace App\Http\Requests\ShortUrls;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreShortUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return $user->can('create', ShortUrl::class);
    }

    /**
        /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'original_url' => ['required', 'url', 'max:2048'],
        ];
    }
}
