<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $table = 'article';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'views',
        'likes'
    ];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'article_id');
    }

    public function files(): MorphToMany
    {
        return $this->morphToMany(
            File::class,
            'fileable',
            'fileable',
            'relation_id',
            'relation_with');
    }

}
