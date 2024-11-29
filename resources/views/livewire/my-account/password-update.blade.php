<section>
    <h2>Wachtwoord Updaten</h2>

    @if (session()->has('pw_update_message'))
        <div class="alert alert-success">
            {{ session('pw_update_message') }}
        </div>
    @endif

    <form wire:submit.prevent="updatePassword">

        <input type="text" name="email" value="{{ $user->email }}" autocomplete="email" style="display: none;">

        <p>
            <label for="current_password">Huidg wachtwoord: <span aria-label="required">*</span></label>
            <input type="password" wire:model="current_password" class="@error('current_password') is-invalid @enderror" autocomplete="current-password">

            @error('current_password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>
        <p>
            <label for="password">Nieuw wachtwoord: <span aria-label="required">*</span></label>
            <input type="password" wire:model="password" class="@error('password') is-invalid @enderror" autocomplete="new-password">

            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>
        <p>
            <label for="password_confirmation">Bevestig wachtwoord: <span aria-label="required">*</span></label>
            <input type="password" wire:model="password_confirmation" class="@error('password_confirmation') is-invalid @enderror" autocomplete="new-password">

            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <button type="submit">Opslaan</button>

    </form>
    
</section>