<?php

namespace App\Models;

use App\Enum\User\RoleEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperArticle
 */
class Article extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'excerpt',
        'tag',
        'photo_article',
    ];

    /**
     * Eloquent Model Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->where('role', RoleEnum::MEMBER->value);
    }
}
