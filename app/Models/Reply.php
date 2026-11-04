<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Reply extends Model
{
    /** @use HasFactory<\Database\Factories\ReplyFactory> */
    use HasFactory;

    protected $table = 'reply';

    protected $fillable = [
        'article_id',
        'parent_id',
        'user_id',
        'content',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'parent_id', 'id')
            ->whereNull('parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Reply::class, 'parent_id', 'id');
    }

    public function files(): MorphToMany
    {
        return $this->morphToMany(
            File::class,
            'fileable',
            'fileable',
            'relation_id',
            'relation_with'
        );
    }
}
