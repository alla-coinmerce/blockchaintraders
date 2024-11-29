<x-guest.layout>

    <h1>{{ __('Wachtwoord vergeten?') }}</h1>

    <p>{{ __('Uw wachtwoord vergeten? Geen probleem. Laat ons uw e-mailadres weten en we zullen u een link e-mailen 
    voor het opnieuw instellen van uw wachtwoord.') }}</p>

    <form method="POST" action="/forgot-password">
        @csrf

        <p>
            <label for="email">{{ __('E-mail') }}</label>
            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>


        @if (session('status'))
            <div class="status_message">
                {{ session('status') }}
            </div>
        @endif

        <input type="submit" value="E-mail wachtwoord reset link">

    </form>

</x-guest.layout>