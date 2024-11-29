<x-web.layout>

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>
    
    <h1>{{ __('Thanks:firstname. We have received your registration in good order.', ['firstname' => session('firstname') ? ',  '.session('firstname') : '']) }}</h1>

    <section>
        <p>
            {{ __('We will get to work for you and will contact you as soon as possible.') }}
        </p>
    </section>

</x-web.layout>