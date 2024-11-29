<section id="two_factor">
    <h2>Twee-factor-authenticatie</h2>

    @if (session()->has('2fa_message'))
        <div class="alert alert-success">
            {{ session('2fa_message') }}
        </div>
    @endif

    @if($user->hasTwoFactorEnabled())
        <p>Twee-factor-authenticatie is ingeschakeld.</p>

        <p>Tijdens de authenticatie wordt u gevraagd om een ​​veilig, willekeurig token. U kunt dit token ophalen uit de authenticatietoepassing van uw telefoon 
            (iOS Authenticator, FreeOTP, Authy en OTP, Google Authenticator of Microsoft Authenticator).</p>

        <p>Bewaar deze herstelcodes in een veilige wachtwoordbeheerder. Ze kunnen worden gebruikt om de toegang tot uw account te 
            herstellen als uw apparaat voor tweefactorauthenticatie verloren is gegaan.</p>

        <div id="recovery_codes">
            @foreach ($recoveryCodes as $recoveryCode)
                @isset($recoveryCode['used_at'])
                    <s>{{ $recoveryCode['code'] }}</s>
                @else
                    {{ $recoveryCode['code'] }}
                @endisset
                <br>
            @endforeach
        </div>

        <button wire:click="generateNewRecoveryCodes">Genereer nieuwe herstelcodes</button>

        <button wire:click="disableTwoFactorAuth">Deactiveer 2FA</button>

    @elseif($preparingTwoFactor)
        <p>Voltooi hieronder het configureren van twee-factor-authenticatie.</p>

        <p>1. Scan deze QR-code met uw authenticator-app:</p>

        <div>{!! $qr_code !!}</div>

        <p>2. Voer de pincode van uw authenticator-app in:</p>

        <form wire:submit.prevent="confirmTwoFactor">
            <p>
                <label for="code">Authenticatie code<span aria-label="required">*</span></label>
                <input type="text" wire:model="code" class="@error('code') is-invalid @enderror">

                @error('code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
            
            <button type="submit">Bevestigen</button>
        </form> 
    @else
        <p>Schakel twee-factor-authenticatie in om uw account extra te beveiligen.</p>

        <button wire:click="activateTwoFactor">Activeer 2FA</button>
    @endif
    
</section>