<section>
    <h2>Profiel</h2>

    @if (session()->has('details_update_message'))
        <div class="alert alert-success">
            {{ session('details_update_message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateDetails">

        <p>
            <label for="firstname">Voornaam: <span aria-label="required">*</span></label>
            <input type="text" wire:model="firstname" class="@error('firstname') is-invalid @enderror">

            @error('firstname')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="lastname">Achternaam: <span aria-label="required">*</span></label>
            <input type="text" wire:model="lastname" class="@error('lastname') is-invalid @enderror">

            @error('lastname')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="email">E-mail: <span aria-label="required">*</span></label>
            <input type="text" wire:model="email" class="@error('email') is-invalid @enderror">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="phone">Telefoonnummer: <span aria-label="required">*</span></label>
            <input type="text" wire:model="phone" class="@error('phone') is-invalid @enderror">

            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="address">Adres: <span aria-label="required">*</span></label>
            <input type="text" wire:model="address" class="@error('address') is-invalid @enderror">

            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="zipcode">Postcode: <span aria-label="required">*</span></label>
            <input type="text" wire:model="zipcode" class="@error('zipcode') is-invalid @enderror">

            @error('zipcode')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <p>
            <label for="city">Plaats: <span aria-label="required">*</span></label>
            <input type="text" wire:model="city" class="@error('city') is-invalid @enderror">

            @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        @php( $countries = Symfony\Component\Intl\Countries::getNames() )
        <p>
            <label for="country_code">Land <span aria-label="required">*</span></label>
            <select wire:model="country_code">
                <option value="">-</option>
                @foreach ($countries as $alpha2Code => $countryName)
                    <option value="{{ $alpha2Code }}">
                        {{ $countryName }}
                    </option>
                @endforeach
            </select>

            @error('country_code')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <button type="submit">Opslaan</button>

    </form>

</section>