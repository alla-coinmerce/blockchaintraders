<?php

namespace App\Http\Livewire\Portal;

use App\Enums\Role;
use App\Models\Fund;
use App\Models\Message;
use App\Models\Participation;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DepositForm extends Component
{
    public $url = "";
    
    public $fund_id = 1;
    public $name;
    public $email;
    public $desired_amount;
    public $message;

    public $modal_id;

    public $success;

    protected $listeners = ['refreshModals' => '$refresh'];

    protected function rules()
    {
        $fund_whitelist = Array();
        foreach(Fund::all() as $fund)
        {
            $fund_whitelist[] = $fund->id;
        }

        return [
            'fund_id' => [
                'required',
                Rule::in($fund_whitelist)
            ],
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'desired_amount' => 'required',
            'message' => 'string|nullable',
        ];
    }

    public function mount()
    {
        $this->success = false;
        $this->url = URL::full();
    }

    public function submit()
    {
        $this->success = false;

        $this->validate();
 
        // Execution doesn't reach here if validation fails.

        $fund = Fund::find($this->fund_id);

        $fundName = $fund ? $fund->name : 'Onbekend fonds met id '.$this->fund_id;

        $this->success = true;

        $linebreak = "\r\n";

        $message = "Fonds: ".$fundName;
        $message .= $linebreak."Gewenst bedrag: ".$this->desired_amount;
        $message .= $linebreak.$linebreak.$this->message;
 
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => 'Portaal bijstortenformulier',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => 'Deposit form'
        ]);

        $mailMessage = "Naam: ".$this->name;
        $mailMessage .= $linebreak."E-mail: ".$this->email;
        $mailMessage .= $linebreak.$linebreak.$this->message;

        $admins = User::where('role', Role::ADMIN->value)
            ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new NewMessagesNotification());
        }
    }

    public function render()
    {
        $funds = Fund::whereHas('participations', function (Builder $query) {
            // $query->where('user_id', Auth::id());
            $query->where('participant_id', Auth::id())
            ->where('participant_type', User::class);
        })->get();;

        return view('livewire.portal.deposit-form', [
            'funds' => $funds
        ]);
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}

