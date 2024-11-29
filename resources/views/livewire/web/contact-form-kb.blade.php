<form wire:submit.prevent="submit">
   
    <input class="@error('firstname') alert alert-danger @enderror" 
        type="text" 
        id="contact_form_firstname"
        wire:model.defer="firstname" 
        placeholder="@error('firstname'){{ $message }}@else{{ __("First name") }}@enderror">

    <input class="@error('lastname') alert alert-danger @enderror" 
        type="text" 
        id="contact_form_lastname"
        wire:model.defer="lastname" 
        placeholder="@error('lastname'){{ $message }}@else{{ __("Last name") }}@enderror">

    <input class="@error('email') alert alert-danger @enderror" 
        type="text" 
        id="contact_form_email"
        wire:model.defer="email" 
        placeholder="@error('email'){{ $message }}@else{{ __("Email address") }} @enderror">
    
    <input class="@error('phone') alert alert-danger @enderror" 
        type="text" 
        id="contact_form_phone"
        wire:model.defer="phone" 
        placeholder="@error('phone'){{ $message }}@else{{ __("Phone number") }}@enderror">

    <div id="contact_form_interest_radio_buttons">
        <p>{{ __("I am interested in…") }}</p>

        <div class="interest_radio_buttons">
            <span>
                <input type="radio" wire:model="interestedIn" name="interestedIn" id="interestedInFunds" value="Funds">
                <label for="interestedInFunds">{{ __("Funds") }}</label>
            </span>

            <span>
                <input type="radio" wire:model="interestedIn" name="interestedIn" id="interestedInKnowledge" value="Knowledge_base">
                <label for="interestedInKnowlegde">{{ __("Knowledge base") }}</label>
            </span>

            <span>
                <input type="radio" wire:model="interestedIn" name="interestedIn" id="interestedInBoth" value="Both">
                <label for="interestedInBoth">{{ __("Both") }}</label>
            </span>
        </div>
    </div>

    @if($success)
       <p class="success_message">{{ __("We have received your request and will contact you as soon as possible.") }}</p>
    @endif

    <x-livewire-honeypot />

    <button type="submit" id="contact_form_submit">{{ $submitButtonText }}{!! $submitButtonIcon !!}</button>
</form>