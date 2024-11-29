<x-web.layout id="fundspage">

    @push('meta')
        <meta name="keywords" content="{{  __("cryptocurrency, funds, investment fund, crypto funds, mutual fund") }}">
        <meta name="description" content="{{  __("At BlockchainTraders you have the option to invest in aggressive or defensive mutual funds with solid strategies and successful track records.") }}">
    @endpush

    <x-slot:title>
        {{ __("Funds | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <h1>{{ __("Our funds") }}</h1>
    </x-slot>

    <section id="our_funds">
        <x-web.funds-shortlist />
    </section>

    <x-web.get-to-know-more />

</x-web.layout>