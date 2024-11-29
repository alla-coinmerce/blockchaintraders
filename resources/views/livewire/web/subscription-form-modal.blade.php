<div class="subscriptionModal">
    <form wire:submit.prevent="submit">
        @csrf
    
        <h2>{{  __("Register direct") }}</h2>
    
        <p class="half_width_on_desktop">
            <label for="subscription_firstname">{{  __("First name") }}<span aria-label="required">*</span></label>
            <input type="text" wire:model.defer="subscription_firstname" class="@error('subscription_firstname') is-invalid @enderror">
    
            @error('subscription_firstname')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </p>
    
        <p class="half_width_on_desktop">
            <label for="subscription_lastname">{{  __("Last name") }}<span aria-label="required">*</span></label>
            <input type="text" wire:model.defer="subscription_lastname" class="@error('subscription_lastname') is-invalid @enderror">
    
            @error('subscription_lastname')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </p>
    
        <p>
            <label for="subscription_email">E-mail<span aria-label="required">*</span></label>
            <input type="text" wire:model.defer="subscription_email" class="@error('subscription_email') is-invalid @enderror">
    
            @error('subscription_email')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </p>

        <div id="kb_register_form_subscription_type_radio_buttons">
            <p>{{ __("Type of subscription") }}<span aria-label="required">*</span></p>

            <div>
                <input type="radio" wire:model.defer="subscription_subscription_type" name="subscription_subscription_type" id="subscription_monthly" value="monthly">
                <label for="subscription_monthly">{{ __("Monthly") }} (€39,95 p/m)</label>
            </div>
            <div>
                <input type="radio" wire:model.defer="subscription_subscription_type" name="subscription_subscription_type" id="subscription_annual" value="annual">
                <label for="subscription_annual">{{ __("Annual") }} (<s>€479,40</s> €399 {{ __("p/y") }})</label>
            </div>
        </div>
    
        <p>
            <label for="subscription_coupon">{{ __("Coupon") }}</label>
            <input type="text" wire:model.defer="subscription_coupon" class="@error('subscription_coupon') is-invalid @enderror">
    
            @error('subscription_coupon')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </p>

        <x-livewire-honeypot />
    
        <button type="submit">{{ __("Continue") }}</button>
    </form>
</div>
