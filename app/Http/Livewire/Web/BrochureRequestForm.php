<?php

namespace App\Http\Livewire\Web;

use App\Enums\Role;
use App\Http\Livewire\Honeypot;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\URL;

class BrochureRequestForm extends Honeypot
{
    public $url = "";

    public $name;
    public $phone;
    public $email;

    public $modal_id;

    public $success;

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string|min:10',
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

        $message .= $linebreak."Document: Brochure";
 
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => 'Website Brochure aanvraag',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => 'Brochure request form'
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
        return view('livewire.web.brochure-request-form');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}


