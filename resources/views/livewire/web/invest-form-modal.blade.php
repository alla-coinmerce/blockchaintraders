<div>
    @if($success)
        <x-portal.success :modal_id="$modal_id" />
    @else
        <form wire:submit.prevent="submit">
            @csrf
        
            <h2 class="interested-heading">{{ __("I am interested") }}</h2>

            <p>{{  __("Enter your details and the desired investment amount. We will then contact you as soon as possible.") }}</p>
        
            <p class="half_width_on_desktop">
                <label for="firstname">{{  __("First name") }}<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="firstname" class="@error('firstname') is-invalid @enderror">
        
                @error('firstname')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p class="half_width_on_desktop">
                <label for="lastname">{{  __("Last name") }}<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="lastname" class="@error('lastname') is-invalid @enderror">
        
                @error('lastname')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <p class="half_width_on_desktop">
                <label for="email">E-mail<span aria-label="required">*</span></label>
                <input type="text" wire:model.defer="email" class="@error('email') is-invalid @enderror">
        
                @error('email')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p class="half_width_on_desktop">
                <label for="phone">{{  __("Phone number") }}</label>
                <input type="text" wire:model.defer="phone" class="@error('phone') is-invalid @enderror">
        
                @error('phone')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>
        
            <p>
                <label for="amount">{{  __("Desired investment") }}</label>
                <select wire:model.defer="amount" class="@error('message') is-invalid @enderror">
                    <option value="€100.000 - €200.000">€100.000 - €200.000</option>
                    <option value="€200.000 - €500.000">€200.000 - €500.000</option>
                    <option value="€500.000 - €1M">€500.000 - €1M</option>
                    <option value="€1M - €2M">€1M - €2M</option>
                    <option value="€2M+">€2M+</option>
                </select>
                
                @error('amount')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </p>

            <x-livewire-honeypot />
        
            <button type="submit">{{  __("Send") }}</button>
        </form>
    @endif
</div>