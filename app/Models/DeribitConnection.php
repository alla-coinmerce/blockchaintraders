<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeribitConnection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subaccount_id'];

    /**
     * Get the Fund associated with this Deribit connection
     */
    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class);
    }
}
