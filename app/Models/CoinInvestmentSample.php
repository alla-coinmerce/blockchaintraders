<?php

namespace App\Models;

use App\Services\CurrencyFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CoinInvestmentSample extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin_id',
        'coin_name',
        'sample_taken_at',
        'value_eurocents',
        'value_euro_millicents',
        'qty'
    ];

    /**
     * Get the value in euros with 2 decimals.
     *
     * @return string
     */
    public function getDisplayValueEurosAttribute()
    {
        return App::make(CurrencyFormatter::class)->formatCurrencyHighPrecion($this->value_euro_millicents);
    }

    /**
     * Get the value in euros with 2 decimals.
     *
     * @return string
     */
    public function getDisplayTotalValueEurosAttribute()
    {
        return App::make(CurrencyFormatter::class)->formatCurrencyHighPrecion($this->value_euro_millicents * $this->qty);
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
