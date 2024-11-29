<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        'date',
        'value_eurocents',
        'value_dollarcents',

        'created_by',
        'updated_by'
    ];

    /**
     * Get the fund that owns the day value.
     */
    public function fund()
    {
        return $this->belongsTo(DayValue::class);
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

        // $string = $cents < 0 ? '-' : '+';

        // $positive_value = $cents < 0 ? 0 - $cents : $cents;

        // return $string.number_format($positive_value / 100, 2, ',', '.');

        return $symbol.number_format($cents / 100, 2, ',', '.');
    }
}
