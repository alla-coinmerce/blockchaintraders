<div>
    @if($success)
        <x-portal.success :modal_id="$modal_id" />
    @else
        <form wire:submit.prevent="submit">
            @csrf

            <h1>Bijstorten</h1>

            <p>Heeft u interesse om bij te storten in dit fonds dan kunt u vrijblijvend uw gegevens en het gewenste bijstort bedrag hier 
                invullen. Wij zullen vervolgens zo snel mogelijk contact met u opnemen.</p>

            <p class="half_width_on_desktop">
                <label for="fund_id">Fondsnaam<span aria-label="required">*</span></label>
                <select wire:model.defer="fund_id" class="@error('fund_id') is-invalid @enderror">
                    @foreach($funds as $fund)
                        <option value="{{ $fund->id }}">
                            {{ $fund->name }}
                        </option>
                    @endforeach
                </select>

                @error('fund_id')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p class="half_width_on_desktop">
                <label for="name">Naam<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">

                @error('name')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p class="half_width_on_desktop">
                <label for="email">E-mail<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

                @error('email')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p class="half_width_on_desktop">
                <label for="desired_amount">Gewenst bijstortbedrag (v.a. €5000)<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="desired_amount" value="{{ old('desired_amount') }}" class="@error('desired_amount') is-invalid @enderror">

                @error('desired_amount')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p>
                <label for="message">Bericht (optioneel)</label>
                <textarea rows="4" wire:model.defer="message" class="@error('message') is-invalid @enderror">
                    {{ old('message') }}
                </textarea>

                @error('message')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <button type="submit">Verstuur</button>
        </form>
    @endif
</div>