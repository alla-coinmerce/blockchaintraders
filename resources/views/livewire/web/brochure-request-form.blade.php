<div>
    @if($success)
        <x-portal.success :modal_id="$modal_id" />
    @else
        <form wire:submit.prevent="submit">
            @csrf
        
            <h2>{{  __("Request Brochure") }}</h2>
        
            <p>
                <label for="name">{{  __("Name") }}<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="name" class="@error('name') is-invalid @enderror">
        
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
        
            <p>
                <label for="email">E-mail<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="email" class="@error('email') is-invalid @enderror">
        
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="phone">{{  __("Phone number") }}</label>
                <input type="text" wire:model.defer="phone" class="@error('phone') is-invalid @enderror">
        
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <x-livewire-honeypot />
        
            <button type="submit">{{  __("Send") }}</button>
        </form>
    @endif
</div>