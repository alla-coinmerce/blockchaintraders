<?php

namespace App\Http\Livewire;

use App\Models\Fund;
use App\Models\FundValue;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ParticipationCreate extends Component
{
    /**
     * @var User
     */
    public $user;
    // public $selectedOption = 'funds';
    public $selectedFundId = '';
    public $purchaseMoment = '';
    public $availablePurchaseMoments = [];
    public $qty = 1.00;
    public $tag = '';


    // public $selectedBasketId = ''; 
    public $selectableFunds;
    public $tags;
    // public $selectableBaskets;

    public function mount() {
        $this->selectableFunds = Fund::all();
        $this->tags = Tag::all();
        // $this->selectableBaskets = Fund::all();
    }

    public function updatedSelectedOption($value)
    {
        // $this->reset(['selectedFundId', 'purchaseMoment', 'qty', 'tag', 'selectedBasketId']);
        $this->reset(['selectedFundId', 'purchaseMoment', 'qty', 'tag']);
        $this->availablePurchaseMoments = [];
        if($value === 'funds'){
            $this->availablePurchaseMoments = FundValue::where('fund_id', $this->selectedFundId)->orderBy('date_time', 'DESC')->get();
        }

    }

    public function updatedSelectedFundId($value)
    {
        $this->availablePurchaseMoments = FundValue::where('fund_id', $value)->orderBy('date_time', 'DESC')->get();
    }

    protected function rules()
    {
        $fundWhitelist = Array();
        foreach(Fund::all() as $fund)
        {
            $fundWhitelist[] = $fund->id;
        }

        $fundValueWhitelist = Array();
        foreach(FundValue::where('fund_id', $this->selectedFundId)->get() as $fundValue)
        {
            $fundValueWhitelist[] = $fundValue->id;
        }

        return [
            // 'selectedOption' => 'required',
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
            'tag' => 'string|max:255|nullable',
            // 'selectedBasketId' => $this->selectedOption === 'baskets' ? 'required|integer|exists:baskets,id' : '',
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

        $this->user->participations()->create([
            'fund_id' => $this->selectedFundId,
            'tag_id' => $tag->id,
            'qty' => $this->qty,
            'purchase_date' => $purchaseMomentFundValue->date,
            'fund_value_id' => $purchaseMomentFundValue->id
        ]);
        
        return redirect()->to(route('users.show', [
            'user' => $this->user
        ]).'#participations');
    }

    public function render()
    {
        return view('livewire.participation-create',[
            'selectableFunds' => Fund::all(),
            'tags' => Tag::all()
        ]);
    }
}
