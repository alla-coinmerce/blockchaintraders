<?php

namespace App\Http\Livewire\Web;

use App\Enums\Role;
use App\Http\Livewire\Honeypot;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\URL;

class ContactFormModal extends Honeypot
{
    public $url = "";

    public $name;
    public $phone;
    public $email;
    public $message;

    public $modal_id;

    public $success;

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string|min:10',
        'email' => 'required|email:rfc,dns',
        'message' => 'string|nullable',
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

        $message = $this->message;
        $message .= $linebreak.$linebreak."Tel: ".$this->phone;
 
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => 'Website contactformulier',
            'message' => $message,
            'read' => false,
            'locale' => app()->getLocale(),
            'url' => $this->url,
            'form_tag' => "Contact form popup"
        ]);

        
        $mailMessage = "Naam: ".$this->name;
        $mailMessage .= $linebreak."Tel: ".$this->phone;
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
        return view('livewire.web.contact-form-modal');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}

