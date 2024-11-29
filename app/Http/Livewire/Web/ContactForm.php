<?php

namespace App\Http\Livewire\Web;

use App\Enums\Role;
use App\Http\Livewire\Honeypot;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\URL;

class ContactForm extends Honeypot
{
    public $submitButtonText = "";

    public $submitButtonIcon = "";

    public $url = "";
    public $formTag = "Website contactform";

    public $firstname;
    public $lastname;
    public $email;
    public $phone;

    public $success;

    protected $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email:rfc,dns',
        'phone' => 'required|string|min:10',
    ];

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

        $message = "Name: ".$this->firstname.' '.$this->lastname;
        $message .= $linebreak."E-mail: ".$this->email;
        $message .= $linebreak."Tel: ".$this->phone;
 
        Message::create([
            'name' => $this->firstname.' '.$this->lastname,
            'email' => $this->email,
            'subject' => 'Website contactformulier',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => $this->formTag
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
        return view('livewire.web.contact-form');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}
