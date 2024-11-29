<div>
    @if($success)
        <x-portal.success :modal_id="$modal_id" />
    @else
        <form wire:submit.prevent="submit">
            @csrf
        
            <h1>Contact opnemen</h1>
        
            <p class="half_width_on_desktop">
                <label for="name">Naam<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="name" value="{{ old('name', $name) }}" class="@error('name') is-invalid @enderror">
        
                @error('name')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p class="half_width_on_desktop">
                <label for="phone">Telefoonnummer<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="phone" value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror">
        
                @error('phone')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p>
                <label for="email">E-mail<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="email" value="{{ old('email', $email) }}" class="@error('email') is-invalid @enderror">
        
                @error('email')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p>
                <label for="message">Bericht<span> (optioneel)</span></label>
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