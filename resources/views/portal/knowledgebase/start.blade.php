<x-portal.knowledge-base-layout id="startpage" :firstname="$user->firstname" :email="$user->email">

    <div class="container">
        <h1>Wat wil je doen?</h1>

        <p>Je kunt ook altijd switchen via het menu.</p>

        <div class="options">
            <div class="block option" onclick="goToPortfolio()">
                <img src="/assets/images/portal/start/icon-portfolio.svg" alt="Icoon portfolio">

                <a href="?choice=portfolio">Naar portfolio</a>

                <p>In je portfolio vind je je beleggingen en de laatste stand van zaken.</p>
            </div>

            <div class="block option" onclick="goToKnowledgeBase()">
                <img src="/assets/images/portal/start/icon-kennisbank.svg" alt="Icon kennisbank">

                <a href="?choice=knowledge_base">Naar kennisbank</a>

                <p>In de kennisbank vind je nuttige artikelen en nieuws over zelf beleggen.</p>
            </div>
        </div>
    </div>

    <script>
        function goToPortfolio()
        {
            window.location.href = "?choice=portfolio";
        }

        function goToKnowledgeBase()
        {
            window.location.href = "?choice=knowledge_base";
        }
    </script>

</x-portal.knowledge-base-layout>