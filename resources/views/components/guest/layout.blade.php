<x-layout {{ $attributes }} class="guest">

    @push('meta')
        <meta name="description" content="BlockchainTraders authenticatie.">
    @endpush

    <x-slot:title>
        {{ $title ?? 'BlockchainTraders' }}
    </x-slot>

    <div id="download_app_bar" class="hide-in-app">
        <span id="close_button" onclick="hideDownloadAppBar()">&times;</span>

        <img src="/assets/images//app-icon.jpg" alt="BlockchainTraders logo" width="44" height="44">

        <div id="download_app_bar_text">
            <h2>BlockchainTraders App</h2>
            <p>Altijd inzicht in uw belegging</p>
        </div>

        <a href="https://webtoapp.design/apps/nl/open_store_or_landing/11880" class="button">Download</a>
    </div>

    <header>
        <img src="/assets/images/logo_with_black_name.svg" alt="Logo BlockchainTraders" width="250" height="106">
    </header>
    
    <main>
        {{ $slot }}
    </main>

    <footer>
        {{ $footer ?? '' }}
    </footer>

    <script>
        function hideDownloadAppBar()
        {
            $('#download_app_bar').hide();
        }
    </script>
    
</x-layout>