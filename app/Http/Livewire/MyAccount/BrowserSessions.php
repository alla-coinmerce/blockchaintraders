<?php

namespace App\Http\Livewire\MyAccount;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class BrowserSessions extends Component
{
    /**
     * @var \App\Models\Session[]
     */
    public $sessions;

    /**
     * @var string
     */
    public $password;

    /**
     * @var boolean
     */
    public $askPassword;

    protected $rules = [
        'password' => 'required'
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->sessions = Array();
        $this->password = '';
        $this->askPassword = false;

        if(null !== $user)
        {
            foreach(auth()->user()->sessions as $session)
            {
                $agent = new Agent();

                $agent->setUserAgent($session->user_agent);

                $platform = $agent->platform();
                $browser = $agent->browser();

                $ip_address = $session->ip_address;
                $last_active = Carbon::createFromTimestamp($session->last_activity)->diffForHumans();

                $is_current_device = $session->id === request()->session()->getId();
                $last_activity = $is_current_device ? 
                    'This device' : 
                    'Last active '.$last_active;

                $output = $platform. ' - '.$browser.'<br>';
                $output .= $ip_address.' '.$last_activity.'<br>';

                $this->sessions[] = $output;
            }
        }
    }

    public function logoutAllSessionsPassword()
    {
        $this->askPassword = true;
    }

    public function logoutAllSessions()
    {
        $this->validate();
        
        try
        {
            Auth::logoutOtherDevices($this->password);
        }
        catch(\Exception $e)
        {
            $this->addError('password', 'Ongeldige wachtwoord.');
        }

        $this->password = '';
    }

    public function render()
    {
        return view('livewire.my-account.browser-sessions');
    }
}
