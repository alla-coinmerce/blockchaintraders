<?php

namespace App\Http\Livewire;

use App\Models\Fund;
use App\Models\FundValue;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ParticipationInvestmentCreate extends Component
{
    /**
     * @var Fund
     */
    public $fund;

    public $selectedFundId = '';
    public $purchaseMoment = '';
    public $availablePurchaseMoments = [];
    public $qty = 1.00;
    public $tag = '';

    protected function rules()
    {
        $fundWhitelist = Array();
        foreach(Fund::whereNot('id', $this->fund->id)->get() as $fund)
        {
            $fundWhitelist[] = $fund->id;
        }

        $fundValueWhitelist = Array();
        foreach(FundValue::where('fund_id', $this->selectedFundId)->get() as $fundValue)
        {
            $fundValueWhitelist[] = $fundValue->id;
        }

        return [
            'selectedFundId' => [
                'required',
                Rule::in($fundWhitelist)
            ],
            'purchaseMoment' => [
                'required',
                Rule::in($fundValueWhitelist)
            ],
            'qty' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,4})?$/', 
                'min:1' 
            ],
            'tag' => 'string|max:255|nullable'
        ];
    }

    public function selectedFundChanged()
    {
        $this->purchaseMoment = '';
        $this->availablePurchaseMoments = FundValue::where('fund_id', $this->selectedFundId)->orderBy('date_time', 'DESC')->get();
    }

    public function submit()
    {
        $this->validate();
 
        // Execution doesn't reach here if validation fails.

        $tagName = '-';

        if(!empty($this->tag))
        {
            $tagName = $this->tag;
        }

        $tag = Tag::firstOrCreate([
            'name' => $tagName
        ]);

        $purchaseMomentFundValue = FundValue::find($this->purchaseMoment);

        $this->fund->participationInvestments()->create([
            'fund_id' => $this->selectedFundId,
            'tag_id' => $tag->id,
            'qty' => $this->qty,
            'purchase_date' => $purchaseMomentFundValue->date,
            'fund_value_id' => $purchaseMomentFundValue->id
        ]);

        return redirect()->to(route('funds.show', [
            'fund' => $this->fund
        ]).'#investments');
    }

    public function render()
    {
        $selectableFunds = Fund::whereNot('id', $this->fund->id)->get();

        return view('livewire.participation-investment-create',[
            'selectableFunds' => $selectableFunds,
            'tags' => Tag::all()
        ]);
    }
}
