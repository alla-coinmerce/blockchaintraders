<x-web.layout id="knowledge_base_registration_confirm_page" class="website_knowledge_base" :darkMode='false'>

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <div class="container">
        <div class="checkmarkCircle">
            <img src="/assets/images/knowledge_base_registration_confirm/check.svg" alt="Check mark">
        </div>
        
        <h1>{{ __("Payment successful") }}</h1>

        <p>{{ __("Your subscription has started successfully. We've sent you an email with more instructions.") }}</p>

        <a href="{{ route('login') }}" class="button">{{ __("To login screen") }}</a>

        <a href="{{ $previousPage }}">{{ __("Back to previous page") }}</a>
    </div>

</x-web.layout>