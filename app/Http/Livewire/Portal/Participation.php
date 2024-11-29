<?php

namespace App\Http\Livewire\Portal;

use App\Models\Participation as ModelsParticipation;
use App\Models\User;
use App\Services\CurrencyFormatter;
use App\Services\ReturnCalculator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Participation extends Component
{
    use WithPagination;

    public $sequenceNumberList;

    public $lastFundValueDate;

    public $tag;
    public $tagFormattedTotalCurrentValueEuros;
    public $sequenceNumber;
    public $purchaseDate;
    public $qty;
    public $formattedPurchaseValueEuros;
    public $formattedCurrentValueEuros;
    public $formattedTotalCurrentValueEuros;
    public $formattedAchievedReturn;

    public $formattedTotalCurrentValueEurosAllParticipations;

    public $userId;
    public $fund;

    public function mount()
    {
        $this->userId = Auth::id();

        /** Create a list of all particitpations of the current User for the selected Fund
         * to create  sequence number list.
         */
        $participations = ModelsParticipation::join('tags', 'tags.id', '=', 'participations.tag_id')
            ->select(
                'participations.id',
                'tags.name as tag',
                )
            ->groupBy(
                'participations.id',
                'tags.name',
                )
            ->where('participant_id', $this->userId)
            ->where('participant_type', User::class)
            ->where('fund_id', $this->fund->id)
            ->orderBy('tags.name', 'ASC')
            ->orderBy('purchase_date', 'ASC')
            ->get();

        $i = 1;
        $tag = null;
        $this->sequenceNumberList = Array();
        foreach($participations as $participation)
        {
            if($tag !== $participation->tag)
            {
                $tag = $participation->tag;
                $i = 1;
            }

            $this->sequenceNumberList[$participation->id] = $i++;
        }

        $this->lastFundValueDate = Carbon::make($this->fund->currentFundValue->date)->format('d-m-Y');

        /** Get the total value of all participations for the current User
         *  For the selected Fund.
         */
        $currencyFormatter = App::make(CurrencyFormatter::class);

        $fundValueEurocents = $this->fund->currentFundValue ? $this->fund->currentFundValue->value_eurocents : 0;

        $qty = ModelsParticipation::where('participant_id', $this->userId)
            ->where('participant_type', User::class)
            ->where('fund_id', $this->fund->id)
            ->sum('qty');

        $totalCurrentValueAllParticipationsEurosCents = $qty * $fundValueEurocents;

        $this->formattedTotalCurrentValueEurosAllParticipations = $currencyFormatter->formatCurrency($totalCurrentValueAllParticipationsEurosCents);
    }

    public function render()
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);
        $returnCalculator = App::make(ReturnCalculator::class);

        $fundValueEurocents = $this->fund->currentFundValue ? $this->fund->currentFundValue->value_eurocents : 0;

        // Get the requested participation
        $participations = ModelsParticipation::join('tags', 'tags.id', '=', 'participations.tag_id')
            ->select(
                'participations.id',
                'participations.fund_id',
                'participations.tag_id',
                'participations.qty',
                'participations.purchase_date',
                'participations.fund_value_id',
                'tags.name as tag',
                DB::raw('SUM(participations.qty) As totalQty'),
                DB::raw("SUM(participations.qty * '$fundValueEurocents') As totalValueEuroCents")
                )
            ->groupBy(
                'participations.id',
                'participations.fund_id',
                'participations.tag_id',
                'participations.qty',
                'participations.purchase_date',
                'participations.fund_value_id',
                'tags.name',
                )
            ->where('participant_id', $this->userId)
            ->where('participant_type', User::class)
            ->where('fund_id', $this->fund->id)
            ->orderBy('tags.name', 'ASC')
            ->orderBy('purchase_date', 'ASC')
            ->paginate(1, ['*'], 'fund'.$this->fund->id.'Page');

        $participation = $participations->first();

        $tagId = $participation->tag_id;

        // Get the total value of all participations with the tag of the current participation
        $qty = ModelsParticipation::where('participant_id', $this->userId)
            ->where('participant_type', User::class)
            ->where('fund_id', $this->fund->id)
            ->where('tag_id', $tagId)
            ->sum('qty');

        $tagFormattedTotalCurrentValueEurosEurosCents = $qty * $fundValueEurocents;

        // Prepare the data
        $purchaseDateFundValue = $participation->purchaseDateFundValue;
        $purchaseValueEuroCents = $purchaseDateFundValue ? $purchaseDateFundValue->value_eurocents : 0;

        $currentValueEurosCents = $this->fund->currentFundValue->value_eurocents;
        $totalCurrentValueEurosCents = $participation->qty * $currentValueEurosCents;
        $achievedReturn = $returnCalculator->calculateReturn($purchaseValueEuroCents, $currentValueEurosCents);

        // Fill the frontend data
        $this->tag = $participation->tag;
        $this->tagFormattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($tagFormattedTotalCurrentValueEurosEurosCents);
        $this->sequenceNumber = $this->sequenceNumberList[$participation->id];
        $this->purchaseDate = date('d-m-Y', strtotime($participation->purchase_date));
        $this->qty = $participation->qty;
        $this->formattedPurchaseValueEuros = $currencyFormatter->formatCurrency($purchaseValueEuroCents);
        $this->formattedCurrentValueEuros = $currencyFormatter->formatCurrency($currentValueEurosCents);
        $this->formattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($totalCurrentValueEurosCents);
        $this->formattedAchievedReturn = $returnCalculator->format($achievedReturn);

        // dd($participations, $participations->first(), $participation, $participation->tag_id);

        return view('livewire.portal.participation', [
            'participations' => $participations
        ]);
    }
}
