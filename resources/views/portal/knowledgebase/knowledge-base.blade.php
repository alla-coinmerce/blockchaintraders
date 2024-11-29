<x-portal.knowledge-base-layout id="knowledgebasepage">
    <h1 id="page_title"><span class="greeting"></span>, {{ $user->firstname }}</h1>
    
    <script>
        var thehours = new Date().getHours();
        var themessage;

        if(thehours < 12)
        {
            themessage = 'Goedemorgen'; 
        }
        else if(thehours < 17) 
        {
            themessage = 'Goedemiddag';

        } 
        else
        {
            themessage = 'Goedenavond';
        }

        $('.greeting').append(themessage);
    </script>

    <div id="leftColumn">
        <h2 id="titleKnowledgeBase">KENNISBANK</h2>

        <section id="startWithCryptoCurrencies">
            <h3>
                <img class="hideWhenDarkMode" src="/assets/images/portal/knowledge_base/icon-start.svg" alt="Icon">
                <img class="hideWhenLightMode" src="/assets/images/portal/knowledge_base/dark_mode/icon-start.svg" alt="Icon">
                Beginnen met cryptocurrencies
            </h3>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Wat zijn cryptocurrencies</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Hoe en waar koop je cryptocurrencies</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Hoe kan je cryptocurrencies veilig opslaan</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Hoe kom je erachter welke cryptocurrencies interessant zijn om te kopen</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">De beste cryptocurrency tools</a>
            </div>
        </section>

        <section id="getMOreOutOfYourCryptoInvestments">
            <h3>
                <img class="hideWhenDarkMode" src="/assets/images/portal/knowledge_base/icon-increase.svg" alt="Icon">
                <img class="hideWhenLightMode" src="/assets/images/portal/knowledge_base/dark_mode/icon-increase.svg" alt="Icon">
                Meer uit je crypto beleggingen halen
            </h3>
            
            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Cryptocurrencies staken</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">DeFi gebruiken</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('article.whatAreCryptoCurrencies') }}">Markt-neutraal rendement maken</a>
            </div>
        </section>

        <section id="usefulSpreadsheets">
            <h3>
                <img class="hideWhenDarkMode" src="/assets/images/portal/knowledge_base/icon-document.svg" alt="Icon">
                <img class="hideWhenLightMode" src="/assets/images/portal/knowledge_base/dark_mode/icon-document.svg" alt="Icon">
                Handige spreadsheets
            </h3>
            
            <div class="linkWrap">
                <a href="{{ route('kb.asset.download', ['filename' => 'QduN7UAO5NxSINGFQ2FhxADxSf7vtXVZjqgPEalS.pdf']) }}" target="_blank" rel="noopener noreferrer">DeFi Stablecoin kansen</a>
            </div>

            <div class="linkWrap">
                <a href="{{ route('kb.asset.download', ['filename' => 'PWTtylck4j3niZNv8lYLntPXFDnQ2qAJWasLqJjN.pdf']) }}" target="_blank" rel="noopener noreferrer">DeFi Crypto kansen</a>
            </div>
        </section>
    </div>

    <div id="rightColumn">
        <h2 id="titleLatestUpdates">LAATSTE UPDATES</h2>

        <section id="latestUpdates">
            @foreach ($articles as $article)
                @if($loop->first)
                    <x-portal.news-article :article="$article" :excerptLength="120" :first="true" />
                @else
                    <x-portal.news-article :article="$article" :excerptLength="90" />
                @endif
            @endforeach
        </section>

        <div class="alignRight">
            <a id="moreUpdatesLink" href="{{ route('kb.archive') }}">Bekijk meer updates <i class="fa fa-arrow-right fa-fw"></i></a>
        </div>
    </div>
</x-portal.knowledge-base-layout>