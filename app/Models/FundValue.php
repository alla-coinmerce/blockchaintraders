<?php

namespace App\Models;

use Carbon\Carbon as CarbonCarbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class FundValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        
        'value_eurocents',
        'value_dollarcents',
        'date_time',
        'date',
        'time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value_eurocents' => 'integer',
        'value_dollarcents' => 'integer',
        'date_time' => 'datetime',
        // 'date' => 'datetime:Y-m-d'
    ];

    /**
     * Get the fund that owns the fund value.
     */
    public function fund()
    {
        return $this->belongsTo(FundValue::class);
    }

    /**
     * Get the NumberOfParticipationsSample that is used to calculate
     * this FundValue
     */
    public function numberOfParticipationsSample(): HasOne
    {
        return $this->hasOne(NumberOfParticipationsSample::class);
    }

    /**
     * Get the CoinInvestmentSamples that are used to calculate
     * this FundValue
     */
    public function coinInvestmentSamples(): HasMany
    {
        return $this->hasMany(CoinInvestmentSample::class);
    }

    /**
     * Get the ParticipationInvestmentSamples that are used to calculate
     * this FundValue
     */
    public function participationInvestmentSamples(): HasMany
    {
        return $this->hasMany(ParticipationInvestmentSample::class);
    }

    /**
     * Get the time in Europe/Amsterdam timezone.
     *
     * @return string
     */
    public function getTimeUtcAttribute()
    {
        return Carbon::parse($this->date_time)->format('H:i:s');
    }

    /**
     * Get the time in Europe/Amsterdam timezone.
     *
     * @return string
     */
    public function getTimeEuropeAmsterdamAttribute()
    {
        return Carbon::parse($this->date_time)->setTimezone('Europe/Amsterdam')->format('H:i:s');
    }

    /**
     * Get the value in euros with 2 decimals.
     *
     * @return string
     */
    public function getDisplayValueEurosAttribute()
    {
        return $this->formattedValue($this->value_eurocents);
    }

    /**
     * Get the value in dollars with 2 decimals.
     *
     * @return string
     */
    public function getDisplayValueDollarsAttribute()
    {
        return $this->formattedValue($this->value_dollarcents, '$');
    }

    private function formattedValue($cents, $symbol="€")
    {
        if(null === $cents)
        {
            return '';
        }

        return $symbol.number_format($cents / 100, 2, ',', '.');
    }
}
