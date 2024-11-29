<?php

namespace App\Http\Livewire\MyAccount;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Symfony\Component\Intl\Countries;

class Details extends Component
{
    /**
     * @var \App\Models\User
     */
    public $user;

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $address;
    public $zipcode;
    public $city;
    public $country_code;

    protected function rules()
    { 
        $country_whitelist = Array();
        foreach(Countries::getNames() as $alpha2Code => $countryName)
        {
            $country_whitelist[] = $alpha2Code;
        }

        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users')->ignore($this->user)
            ],
            'phone' => 'required|min:10|max:20',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:8',
            'city' => 'required|string|max:255',
            'country_code' => [
                Rule::in($country_whitelist)
            ],
        ];
    }

    public function mount()
    {
        $this->firstname = $this->user->firstname;
        $this->lastname = $this->user->lastname;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->zipcode = $this->user->zipcode;
        $this->city = $this->user->city;
        $this->country_code = $this->user->country_code;
    }

    /**
     * Update the user detail
     */
    public function updateDetails()
    {
        $this->validate();
        
        $this->user->firstname = $this->firstname;
        $this->user->lastname = $this->lastname;
        $this->user->email = $this->email;
        $this->user->phone = $this->phone;
        $this->user->address = $this->address;
        $this->user->zipcode = $this->zipcode;
        $this->user->city = $this->city;
        $this->user->country_code = $this->country_code;

        $this->user->save();

        session()->flash('details_update_message', 'Uw gegevens zijn aangepast.');
    }

    public function render()
    {
        return view('livewire.my-account.details');
    }
}
