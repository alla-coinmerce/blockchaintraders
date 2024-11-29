<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'locale',
        'original_file_name',
        'storage_path'
    ];

    /**
     * Get the post that owns the attachment
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
