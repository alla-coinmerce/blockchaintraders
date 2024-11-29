<?php

namespace App\Http\Livewire\Web;

use App\Enums\Role;
use App\Http\Livewire\Honeypot;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\URL;

class InvestFormModal extends Honeypot
{
    public $url = "";

    public $firstname = "";
    public $lastname = "";
    public $email = "";
    public $phone = "";
    public $amount = "€100.000 - €200.000";

    public $modal_id;

    public $success;

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email:rfc,dns',
        'phone' => 'string|min:10|nullable',
        'amount' => 'required|string'
    ];

    protected $listeners = ['refreshModals' => '$refresh'];

    public function mount()
    {
        $this->success = false;
        $this->url = URL::full();
    }

    public function processForm()
    {
        $this->success = false;

        $this->validate();
 
        // Execution doesn't reach here if validation fails.

        $this->success = true;

        $linebreak = "\r\n";

        $message = "Naam: ".$this->firstname.' '.$this->lastname;
        $message .= $linebreak."E-mail: ".$this->email;
        $message .= $linebreak."Tel: ".$this->phone;
        $message .= $linebreak."Bedrag: ".$this->amount;
 
        Message::create([
            'name' => $this->firstname.' '.$this->lastname,
            'email' => $this->email,
            'subject' => 'Website aanmelding ik wil investeren',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => 'Invest request form'
        ]);

        $admins = User::where('role', Role::ADMIN->value)
            ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new NewMessagesNotification());
        }
    }

    public function render()
    {
        return view('livewire.web.invest-form-modal');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}
