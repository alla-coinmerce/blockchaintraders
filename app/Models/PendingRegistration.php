<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'fund_name',
        'desired_participation_date',
        'desired_amount',
        'identification',
        'bank_statement',
        'coc_extract'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user', 'identificationDocument', 'bankStatementDocument', 'cocExtractDocument'];

    /**
     * Get the user associated with the pending registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user associated with the pending registration.
     */
    public function identificationDocument(): BelongsTo
    {
        return $this->belongsTo(UserDocument::class, 'identification', 'id');
    }

    /**
     * Get the bank_statement associated with the pending registration.
     */
    public function bankStatementDocument(): BelongsTo
    {
        return $this->belongsTo(UserDocument::class, 'bank_statement', 'id');
    }

    /**
     * Get the coc_extract associated with the pending registration.
     */
    public function cocExtractDocument(): BelongsTo
    {
        return $this->belongsTo(UserDocument::class, 'coc_extract', 'id');
    }
}
