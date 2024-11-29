<x-layout id="dashboardpage" class="portal">

@push('vite')
    @vite(['resources/js/portal.js'])
@endpush

@push('meta')
    <meta name="description" content="Beheer uw crypto portefeuille.">
    <meta http-equiv="refresh" content="3600">
@endpush

@push('scripts')
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
@endpush

<x-slot:title>
    BlockchainTraders
</x-slot>

<header>
    <a href="/"><img src="/assets/images/Logo.svg" alt="Logo BlockchainTraders" width="112" height="92"></a>

    <span>{{ $date }}</span>    
</header>

<main>
    @foreach ($funds as $fund)
        <section>
            <h2>BLOCKCHAINTRADERS {{ strtoupper($fund->name) }}</h2>

            <div class="participation_returns item">
                <h3>Participatie waarde</h3>

                <p>
                    <span class="with_left_border value">€ {{ $fund->participationValue }}</span>
                    <span @class([
                        'diff',
                        'negative' => !$fund->returnIsPositive,
                        'positive' => $fund->returnIsPositive
                    ])>{{ $fund->participationValueSinceStart }}% sinds start
                    </span>
                </p>
            </div>

            <div class="fund_returns">
                <x-portal.dashboard-value label="Rendement YTD" :value="$fund->returnYtd" />

                <x-portal.dashboard-value label="Rendement maand" :value="$fund->returnMonth" />

                <x-portal.dashboard-value label="Rendement 24u" :value="$fund->returnDay" />
            </div>

            <div class="plot item">
                <x-fund-plot :fund="$fund->fundModel" :fontSize="25"/>
            </div>
        </section>
    @endforeach
</main>

</x-layout>