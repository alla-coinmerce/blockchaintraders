<x-guest.layout>

    <h1>Twee-factor-authenticatie</h1>

    <p>Om door te gaan, opent u uw Authenticator-app en geeft u uw 2FA-code op.</p>

    <form method="post">
        @csrf
        
        @if($errors->isNotEmpty())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p>
            <input type="text" name="{{ $input }}" id="{{ $input }}"
                    class="@error($input) is-invalid @enderror form-control form-control-lg"
                    minlength="6" placeholder="123456" required>
        </p>

        <p>
            
            <label for="safe_device">
                <input type="checkbox" name="safe_device" value="1">{{ __("Ik vertrouw dit apparaat. Vraag :days dagen lang geen codes aan.", ['days' => config('two-factor.safe_devices.expiration_days')]) }}</label>
        </p>
            
        <button type="submit">Bevestigen</button>
    </form>

</x-guest.layout>