<?php

namespace App\Http\Livewire\Portal;

use App\Enums\Role;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessagesNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class ContactForm extends Component
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
        'phone' => 'required|string',
        'email' => 'required|email:rfc,dns',
        'message' => 'string|nullable',
    ];

    protected $listeners = ['refreshModals' => '$refresh'];

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

        $this->success = true;

        $linebreak = "\r\n";

        $message = $this->message;
        $message .= $linebreak.$linebreak."Tel: ".$this->phone;
 
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => 'Portaal contactformulier',
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
        return view('livewire.portal.contact-form');
    }

    public function dehydrate()
    {
        $this->success = false;
    }
}
