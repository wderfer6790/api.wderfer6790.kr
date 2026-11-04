<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $table = 'file';

    protected $fillable = [
        'uploaded_by',
        'disk',
        'path',
        'name',
        'mime_type',
        'size'
    ];

    public function user(): MorphToMany
    {
        return $this->morphedByMany(
            User::class,
            'fileable',
            'fileable',
            'relation_id',
            'relation_with'
        );
    }

    public function article(): MorphToMany
    {
        return $this->morphedByMany(
            Article::class,
            'fileable',
            'fileable',
            'relation_id',
            'relation_with'
        );
    }

    public function reply(): MorphToMany
    {
        return $this->morphedByMany(
            Reply::class,
            'fileable',
            'fileable',
            'relation_id',
            'relation_with'
        );
    }
}
