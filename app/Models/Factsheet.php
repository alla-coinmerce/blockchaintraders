<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factsheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'week',
        'year',
        'original_file_name',
        'storage_path',

        'created_by',
        'updated_by'
    ];

    /**
     * Get the Fund that owns the Factsheet.
     */
    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }
}
