<x-web.layout id="knowledge_base_registration_error_page" class="website_knowledge_base" :darkMode='false'>

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <div class="container">
        <div class="checkmarkCircle">
            <img src="/assets/images/knowledge_base_registration_error/exclamation-mark.svg" alt="Exclamation mark">
        </div>
        
        <h1>{{ __("Payment failed") }}</h1>

        <p>{{ __("Unfortunately something went wrong with the payment. Please try again or contact us.") }}</p>

        @if (!empty($previousPage))
            <a href="{{ $previousPage }}" class="button">{{ __("Try again") }}</a>
        @endif    

        <a onclick="open_modal('contact')">{{ __("Contact") }}</a>
    </div>

</x-web.layout>