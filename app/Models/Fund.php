<?php

namespace App\Models;

use App\Services\CurrencyFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class Fund extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'public',
        'start_fund_value_id',

        'auto_update_enabled',
        'extrapolate_enabled',
        'extrapolation_factor',

        'created_by',
        'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'auto_update_enabled' => false,
        'extrapolate_enabled' => false
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'public' => 'boolean',
        'auto_update_enabled' => 'boolean',
        'extrapolate_enabled' => 'boolean',
        'extrapolation_factor' => 'float'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the coins where this fund has invested in.
     */
    public function coinInvestments()
    {
        return $this->hasMany(CoinInvestment::class);
    }

    /**
     * Get the DeribitConnection associated with this Fund
     */
    public function deribitConnection(): HasOne
    {
        return $this->hasOne(DeribitConnection::class);
    }

    /**
     * Get the participations for this fund.
     * 
     * Note: these are the participations of other Users and Funds
     *       participating in this Fund. So these are NOT the participations
     *       this Fund is investing in.
     */
    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Get the number of participations excluding demo accounts
     */
    public function numberOfParticipationsExcludingDemoAccounts(): int
    {
        return $this->participations()->excludingDemoAccounts()->sum('qty');
    }

    /**
     * 
     */
    public function getTotalParticipationValueInEuroCentsForFund(Fund $fund)
    {
        $totalNumberOfParticipations = $this->getParticipationsQtyForFund($fund);

        $lastFundValue = $fund->current_fund_value->value_eurocents;

        return $totalNumberOfParticipations * $lastFundValue;
    }

    /**
     * Get the participations where this fund has
     * invested in.
     */
    public function participationInvestments(): MorphMany
    {
        return $this->morphMany(Participation::class, 'participant');
    }

    /**
     * Get the quantity of the participations this fund
     * has invested in for the given fund.
     */
    public function getParticipationsQtyForFund(Fund $fund)
    {
        return $this->participationInvestments->where('fund_id', $fund->id)->sum('qty');
    }

    /**
     * Get the total number of participations for this fund.
     */
    public function getParticipationsQtyAttribute()
    {
        return $this->participations->sum('qty');
    }

    /**
     * Get the total value of participations for this fund.
     */
    public function getParticipationsTotalValueAttribute()
    {
        $value = 0;

        foreach($this->participations as $participation)
        {
            $value += $participation->qty * $this->currentFundValue->value_eurocents;
        }
        
        return '€'.number_format($value / 100, 2, ',', '.');
    }

    /**
     * Get the total achieved return for this fund.
     */
    public function getParticipationsTotalAchievedReturnAttribute()
    {
        $purchaseValueTotal = 0;
        $currentValueTotal = 0;

        foreach($this->participations as $participation)
        {
            $purchaseValue = $participation->purchaseDateFundValue;
            $currentValue = $this->currentFundValue;

            if( ( $purchaseValue !== null) &&
                ( $currentValue  !== null) )
            {
                $purchaseValueTotal += $participation->qty * $purchaseValue->value_eurocents;
                $currentValueTotal += $participation->qty * $currentValue->value_eurocents;
            }
        }

        // Prevent division by zero
        if($purchaseValueTotal === 0)
        {
            return '';
        }

        $returnValue = (($currentValueTotal - $purchaseValueTotal) / $purchaseValueTotal) * 100;

        return number_format($returnValue, 2, ',', '.');
    }

    /**
     * Get the factsheets for this fund.
     */
    public function factsheets()
    {
        return $this->hasMany(Factsheet::class)
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc');
    }

    /**
     * Get the fundValues for this fund.
     */
    public function fundValues()
    {
        return $this->hasMany(FundValue::class);
    }

    /**
     * Get the fundValues for this fund.
     */
    public function fundValuesDescending()
    {
        return $this->hasMany(FundValue::class)->orderBy('date_time', 'desc');
    }

    /**
     * Get the FundValue to use as start date
     */
    public function startFundValue(): HasOne
    {
        return $this->hasOne(FundValue::class, 'id', 'start_fund_value_id');
    }

    /**
     * Get the current FundValue
     */
    public function getCurrentFundValueAttribute()
    {
        return FundValue::where('fund_id', $this->id)
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['06:50:00'])
            ->orderBy('date_time', 'DESC')
            ->first();

        // return $this->fundValues->sortByDesc('date_time')->first();
    }

    /**
     * Get the FundValue 24h before the last FundValue
     */
    public function getFundValueTwentyFourHourBeforeLastFundValueAttribute()
    {
        $lastFundValue = $this->currentFundValue;

        $dateTimeOneDayAgo = Carbon::parse($lastFundValue->date_time)->subDay()->addMinutes(10);

        return $this->fundValues
            ->sortByDesc('date_time')
            ->where('date_time', '<=', $dateTimeOneDayAgo->toDateTimeString())
            ->first();
    }

    /**
     * Get the FundValue at given date
     */
    public function fundValueAtDate($date)
    {
        return $this->fundValues->where('date', $date)->whereBetween('time', ['09:00', '13:00'])->first();
    }

    /**
     * The users that are participating in this fund.
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'participant', 'participations')->distinct();
    }

    /**
     * The funds that are participating in this fund.
     */
    public function participatingFunds(): MorphToMany
    {
        return $this->morphedByMany(Fund::class, 'participant', 'participations')->distinct();
    }

    /**
     * Participants
     */
    public function participants()
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);

        $users = $this->users()->where('demo_account', false)->get()->map(fn($user) => (object)[
            'name' => $user->firstname.' '.$user->lastname,
            'route' => route('users.show', ['user' => $user]),
            'participationsQtyForFund' => $user->getParticipationsQtyForFund($this),
            'totalValueEuroCents' => $currencyFormatter->formatCurrency($user->getTotalParticipationValueInEuroCentsForFund($this))
        ]);

        $participatingFunds = $this->participatingFunds()->get()->map(fn($participatingFund) => (object)[
            'name' => $participatingFund->name,
            'route' => route('funds.show', ['fund' => $participatingFund]),
            'participationsQtyForFund' => $participatingFund->getParticipationsQtyForFund($this),
            'totalValueEuroCents' => $currencyFormatter->formatCurrency($participatingFund->getTotalParticipationValueInEuroCentsForFund($this))
        ]);

        $participants = collect()->merge($users)->merge($participatingFunds)->sortBy('name');

        return $participants;
    }
    
    /**
     * The tags that are used for participation in this fund.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'participations')->distinct();
    }
}
