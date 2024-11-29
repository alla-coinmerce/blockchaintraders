<x-guest.layout>

    <h1>{{ __('Reset wachtwoord') }}</h1>

    <form method="POST" action="/reset-password">
        @csrf

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

        <input type="hidden" name="token" value="{{ $token }}" required>

        @if (session('status'))
            <div class="status_message">
                {{ session('status') }}
            </div>
        @endif

        <input type="submit" value="{{ __('Wachtwoord instellen') }}">

    </form>

</x-guest.layout>