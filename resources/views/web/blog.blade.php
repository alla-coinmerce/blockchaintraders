<x-web.layout id="blogpage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        Blog | BlockchainTraders
    </x-slot>
    
    <x-slot:heading>
        <h1>Blog</h1>
    </x-slot>

    <livewire:web.blog />

</x-web.layout>