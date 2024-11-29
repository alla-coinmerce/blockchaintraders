<?php

namespace App\Http\Livewire\MyAccount;

use Livewire\Component;

class TwoFactor extends Component
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $qr_code;

    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $string;

    /**
     * @var string
     */
    public $code;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $recoveryCodes;

    protected $rules = [
        'code' => 'required|numeric'
    ];

    /**
     * @var boolean
     */
    public $preparingTwoFactor;

    public function mount()
    {
        $this->preparingTwoFactor = false;
        $this->code = '';

        try
        {
            $this->recoveryCodes = $this->user->getRecoveryCodes();
        }
        catch( \Exception $e)
        {
            $this->recoveryCodes = Array();
        }
    }

    /**
     * Prepare enabling 2FA
     */
    public function activateTwoFactor()
    {
        $secret = $this->user->createTwoFactorAuth();

        $this->preparingTwoFactor = true;

        $this->qr_code = $secret->toQr();     // As QR Code
        $this->uri     = $secret->toUri();    // As "otpauth://" URI.
        $this->string  = $secret->toString(); // As a string
    }

    /**
     * Confirm 2FA after enabling
     */
    public function confirmTwoFactor()
    {
        $this->validate();
        
        $activated = $this->user->confirmTwoFactorAuth($this->code);
        
        if($activated)
        {
            $this->recoveryCodes = $this->user->getRecoveryCodes();

            $this->preparingTwoFactor = false;

            session()->flash('2fa_message', 'Twee-factor-authenticatie geactiveerd.');
        }
        else
        {
            $this->addError('code', 'Ongeldige code');
        }
    }

    /**
     * Generate new recoveryCodes
     */
    public function generateNewRecoveryCodes()
    {
        $this->recoveryCodes = $this->user->generateRecoveryCodes();
    }

    /**
     * Disable 2FA
     */
    public function disableTwoFactorAuth()
    {
        $this->user->disableTwoFactorAuth();
        
        session()->flash('2fa_message',  'Twee-factor-authenticatie is uitgeschakeld!');
    }

    public function render()
    {
        return view('livewire.my-account.two-factor');
    }
}
