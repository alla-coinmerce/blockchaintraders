<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinInvestment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fund_id',
        
        'coin_id',
        'coin_name',
        'qty'
    ];

    /**
     * Get the fund that owns the CoinInvestment.
     */
    public function fund()
    {
        return $this->belongsTo(CoinInvestment::class);
    }
}
