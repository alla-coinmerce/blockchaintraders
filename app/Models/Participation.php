<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Participation extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'user_id',
        'tag_id',
        'qty',
        'purchase_date',

        'created_by',
        'updated_by',

        'participant_type',
        'participant_id',
        'fund_value_id'
    ];

    /**
     * Get the user that owns the participation.
     */
    public function user()
    {
        return $this->morphTo('participant', 'participant_type', 'participant_id');
    }

    /**
     * Get the participant (User or Fund)
     */
    public function participant(): MorphTo
    {
        return $this->morphTo('participant');
    }

    /**
     * Get the fund that this participation belongs to.
     * 
     * Note: this is not a participating Fund
     */
    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    /**
     * Get the tag that this participation belongs to.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Scope a query to only include participations of a given fund.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $fund_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFund($query, $fund_id)
    {
        return $query->where('fund_id', '=', $fund_id);
    }

    /**
     * Scope a query to exclude participations that belong to demo accounts.
     */
    public function scopeExcludingDemoAccounts(Builder $query): void
    {
        $query->whereHasMorph(
                'participant',
                Fund::class,
            )
            ->orWhereDoesntHaveMorph(
                'participant',
                User::class,
                function (Builder $query) {
                    $query->where('demo_account', true);
                }
            );
    }

    /**
     * Scope a query to only include participations of a given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function scopeUser($query, $user_id)
    // {
    //     return $query->where('user_id', '=', $user_id);
    // }

    /**
     * Get the participation's fundvalue at the purchase date.
     */
    public function purchaseDateFundValue(): BelongsTo
    {
        return $this->belongsTo(FundValue::class, 'fund_value_id');
    }

    /**
     * Get the participations fundvalue for the current date.
     */
    public function getCurrentFundValueAttribute()
    {
        return $this->fund->currentFundValue;
    }

    /**
     * Get the participations fundvalue at the purchase date.
     */
    public function getDisplayValueEurosPurchaseDateAttribute()
    {
        $fundvalue = $this->purchaseDateFundValue;

        return $fundvalue ? '€'.$this->formattedValue($fundvalue->value_eurocents) : '';
    }

    /**
     * Get the participations total value for the current date.
     */
    public function getDisplayValueEurosCurrentDateTotalAttribute()
    {
        $fundvalue = $this->currentFundValue;

        return $fundvalue ? '€'.$this->formattedValue($fundvalue->value_eurocents * $this->qty) : '';
    }

    /**
     * Get the participations achieved return.
     */
    public function getAchievedReturnAttribute()
    {
        $fundvalue_purchase_date = $this->purchaseDateFundValue;
        $fundvalue_current_date = $this->currentFundValue;

        if( ( $fundvalue_purchase_date === null) ||
            ( $fundvalue_current_date  === null) )
        {
            return '';
        }

        $returnValue = (($fundvalue_current_date->value_eurocents - $fundvalue_purchase_date->value_eurocents) / $fundvalue_purchase_date->value_eurocents) * 100;

        return number_format($returnValue, 2, ',', '.');
    }

    private function formattedValue($cents)
    {
        return ($cents !== null) ? number_format($cents / 100, 2, ',', '.') : '';
    }
}
