<form wire:submit.prevent="submit">
   
    <input class="@error('firstname') alert alert-danger @enderror" 
        type="text" 
        wire:model.defer="firstname" 
        placeholder="@error('firstname'){{ $message }}@else{{ __("First name") }}@enderror">

    <input class="@error('lastname') alert alert-danger @enderror" 
        type="text" 
        wire:model.defer="lastname" 
        placeholder="@error('lastname'){{ $message }}@else{{ __("Last name") }}@enderror">

    <input class="@error('email') alert alert-danger @enderror" 
        type="text" 
        wire:model.defer="email" 
        placeholder="@error('email'){{ $message }}@else{{ __("Email address") }} @enderror">
    
    <input class="@error('phone') alert alert-danger @enderror" 
        type="text" 
        wire:model.defer="phone" 
        placeholder="@error('phone'){{ $message }}@else{{ __("Phone number") }}@enderror">

    @if($success)
       <p class="success_message">{{ __("We have received your request and will contact you as soon as possible.") }}</p>
    @endif

    <x-livewire-honeypot />

    <button type="submit">{{ $submitButtonText }}{!! $submitButtonIcon !!}</button>
</form>