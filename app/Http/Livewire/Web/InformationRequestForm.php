<?php

namespace App\Http\Livewire\Web;

use App\Enums\Role;
use App\Http\Livewire\Honeypot;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\URL;

class InformationRequestForm extends Honeypot
{
    public $url = "";

    public $requested_document;
    public $name;
    public $phone;
    public $email;
    public $complete_info_package = false;

    public $modal_id;

    public $success;

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'string|min:10|nullable',
        'email' => 'required|email:rfc,dns',
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

        $message = "Naam: ".$this->name;
        $message .= $linebreak."E-mail: ".$this->email;
        $message .= $linebreak."Tel: ".$this->phone;

        $message .= $linebreak."Document: ".$this->requested_document;

        if($this->complete_info_package)
        {
            $message .= $linebreak.$linebreak."Wil graag het volledige informatiepakket.";
        }
 
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => 'Website fonds informatie verzoek',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => 'Information request form'
        ]);

        
        $mailMessage = $linebreak.$linebreak.$message;

        $admins = User::where('role', Role::ADMIN->value)
            ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new NewMessagesNotification());
        }
    }

    public function render()
    {
        return view('livewire.web.information-request-form');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}


