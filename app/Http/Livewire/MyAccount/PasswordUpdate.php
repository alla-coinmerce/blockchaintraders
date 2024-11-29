<?php

namespace App\Http\Livewire\MyAccount;

use App\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class PasswordUpdate extends Component
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirmation;

    protected function rules()
    { 
        return [
            'current_password' => 'required|current_password',
            'password' => [
                'required',
                'confirmed',
                new Password
            ]
        ];
    }

    /**
     * Update the password
     */
    public function updatePassword()
    {
        $this->validate();
        
        $this->user->forceFill([
            'password' => Hash::make($this->password)
        ])->setRememberToken(Str::random(60));

        $this->user->save();

        request()->session()->invalidate();
    
        request()->session()->regenerateToken();

        Auth::login($this->user);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('pw_update_message', 'Uw nieuwe wachtwoord is opgeslagen.');
    }

    public function render()
    {
        return view('livewire.my-account.password-update');
    }
}
