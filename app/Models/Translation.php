<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'translatable_id',
        'translatable_type',

        'locale',
        'field',
        'translation'
    ];

    /**
     * Get the parent translatable model
     */
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }
}
