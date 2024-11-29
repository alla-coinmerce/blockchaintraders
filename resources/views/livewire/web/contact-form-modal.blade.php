<div>
    @if($success)
        <x-portal.success :modal_id="$modal_id" />
    @else
        <form wire:submit.prevent="submit">
            @csrf
        
            <h2>{{  __("Contact") }}</h2>
        
            <p class="half_width_on_desktop">
                <label for="name">{{  __("Name") }}<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="name" value="{{ old('name', $name) }}" class="@error('name') is-invalid @enderror">
        
                @error('name')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p class="half_width_on_desktop">
                <label for="phone">{{  __("Phone number") }}<span aria-label="required">*</span></label>
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
                <label for="message">{{  __("Message") }}<span> ({{  __("optional") }})</span></label>
                <textarea rows="4" wire:model.defer="message" class="@error('message') is-invalid @enderror">
                    {{ old('message') }}
                </textarea>
        
                @error('message')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <x-livewire-honeypot />
        
            <button type="submit">{{  __("Send") }}</button>
        </form>
    @endif
</div>