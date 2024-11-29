<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',

        'created_by',
        'updated_by'
    ];

    /**
     * 
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->getName($value)
        );
    }

    private function getName($value)
    {
        return $value === '-' ? '' : $value;
    }

    /**
     * Get the participations for the taag.
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Get the participations for the taag.
     */
    public function participations_for_fund($id)
    {
        return $this->participations->where('fund_id', $id);
    }

    /**
     * Get the total value of all participations with this tag.
     */
    public function getTotalValueAttribute()
    {
        $value = 0;

        foreach($this->participations as $participation)
        {
            // dump('Participation '.$participation->id);
            $value += $participation->currentFundValue->value_eurocents;
        }

        return $value;
    }

    /**
     * Get the total value of all participations with this tag.
     */
    public function totalValue_for_fund($id)
    {
        $value = 0;

        foreach($this->participations_for_fund($id) as $participation)
        {
            $value += $participation->currentFundValue->value_eurocents * $participation->qty;
        }

        return $value;
    }

    /**
     * The funds that have participations that use this tag.
     */
    public function funds()
    {
        return $this->belongsToMany(Fund::class, 'participations')->distinct();
    }
}
