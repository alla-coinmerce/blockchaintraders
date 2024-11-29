<x-guest.layout id="setPasswordPage">

    <h1>Welkom</h1>

    <p>Om uw account te beveiligen dient u een sterk wachtwoord in te stellen.</p>

    <p>Uw wachtwoord moet minimaal 8 tekens lang zijn. We raden de volgende richtlijnen aan om een ​​sterk wachtwoord te maken.</p>

    <ul>
        <li>Een combinatie van hoofdletters, kleine letters, cijfers en symbolen.</li>
        <li>Geen woord dat in een woordenboek staat of de naam van een persoon, personage, product of organisatie.</li>
        <li>Aanzienlijk anders dan uw eerdere wachtwoorden.</li>
        <li>Gemakkelijk voor u om te onthouden, maar moeilijk voor anderen om te raden. Overweeg een goed te onthouden zin te gebruiken, zoals "6MonkeysRLooking^"</li>
    </ul>

    <p>
        <b>Tip:</b> Geen zin om zelf sterke wachtwoorden te bedenken? Gebruik een wachtwoordkluis zoals <a href="https://keepass.info/">KeePass</a> om
        uw wachtwoorden genereren en opslaan.
    </p>

    <form method="POST" action="{{ $setPasswordRoute }}">
        @csrf

        <input type="hidden" name="hash" value="{{ $hash }}">

        <p>
            <label for="email">{{ __('E-mail') }}</label>
            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="password">{{ __('Wachtwoord') }}</label>
            <input type="password" name="password" value="{{ old('password') }}" class="@error('password') is-invalid @enderror" autocomplete="new-password">

            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="password_confirmation">{{ __('Bevestig wachtwoord') }}</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="@error('password_confirmation') is-invalid @enderror" autocomplete="new-password">

            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        @if (session('status'))
            <div class="status_message">
                {{ session('status') }}
            </div>
        @endif

        <input type="submit" value="Verstuur">
    </form>

</x-guest.layout>