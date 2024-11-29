<x-guest.layout>

    <form method="POST" action="/login">
        @csrf
        
        <p>
            <label for="email">{{ __('E-mailadres') }}</label>
            <input type="text" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="password">{{ __('Wachtwoord') }}</label>
            <input type="password" name="password" value="{{ old('password') }}" class="@error('password') is-invalid @enderror" autocomplete="password">

            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <input type="checkbox" name="remember" value="1">
            <label for="remember">{{ __("Ingelogd blijven") }}</label>

            @error('remember')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <x-status-message/>

        <input type="submit" value="{{ __('Inloggen') }}">

        
    </form>

    <x-slot:footer>
        <a href="/wachtwoord-vergeten">{{ __('Wachtwoord vergeten?') }}</a>
    </x-slot:footer>

</x-guest.layout>