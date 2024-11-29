<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParticipationInvestmentSample extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sample_taken_at',
        'value_eurocents',
        'number_of_participations',
        'sample_source_id'
    ];

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
     * Get the value in euros with 2 decimals.
     *
     * @return string
     */
    public function getDisplayTotalValueEurosAttribute()
    {
        return $this->formattedValue($this->value_eurocents * $this->number_of_participations);
    }

    private function formattedValue($cents, $symbol="€")
    {
        if(null === $cents)
        {
            return '';
        }

        return $symbol.number_format($cents / 100, 2, ',', '.');
    }

    /**
     * Get the Fund associated with the ParticipationInvestment.
     */
    public function investedInFund(): HasOne
    {
        return $this->hasOne(Fund::class, 'id', 'sample_source_id');
    }
}
