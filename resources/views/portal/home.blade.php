<x-portal.portfolio-layout id="homepage" :firstname="$user->firstname" :email="$user->email">

    @push('meta')
        <meta http-equiv="refresh" content="3600">
    @endpush
   
    <div class="portalTitleBlock">
        <h1 id="page_title"><span class="greeting"></span>, {{ $user->firstname }}</h1>

        <p class="postalLatestUpdate"><b>Laatste update: </b>{{ $latestUpdate }}</p>
    </div>

    <script defer>
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

    <section id="total_value" class="with_details">
        
        <div class="summary">
            <div class="summary_inner">
                <h2>Totale waarde</h2>
                <p>De totale waarde van uw participaties</p>

                <div class="total_and_diff">
                    <span class="overall_total">
                        €{{ $user->formattedTotalCurrentValueEuros }}
                    </span>
                    <span @class([
                        'diff',
                        'negative' => $user->diffValueEuroCents < 0,
                        'positive' => $user->diffValueEuroCents >= 0
                    ])>
                        <span class="value">{{ $user->formattedDiffValueEuros }}</span><br>totale looptijd
                    </span>
                </div>
            </div>

            @if($multifundParticipant)
                <hr>

                <button class="summaryButton" onclick="toggleDetails('#total_value')">Bekijk specificaties <i class="fa-solid fa-chevron-down fa-fw"></i></button>
            @endif
        </div>

        @if($multifundParticipant)
            <div class="details">
                @foreach($user->funds as $fund)
                    <div>
                        <h3>{{ $fund->name }}</h3>
                        <div>
                            <span class="subtotal">
                                €{{ $fund->formattedTotalCurrentValueEuros }}
                            </span>
                            <span @class([
                                'diff',
                                'negative' => $fund->diffValueEuroCents < 0,
                                'positive' => $fund->diffValueEuroCents >= 0
                            ])>
                                <span class="value">{{ $fund->formattedDiffValueEuros }}</span> totale looptijd
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <section id="achieved_return" class="with_details">

        <div class="summary">
            <div class="summary_inner">
                <h2>Behaald rendement</h2>
                <p>Het gemiddelde rendement van uw participaties</p>

                <div class="total_and_diff">
                    <span class="overall_total">
                        {{ $user->formattedAchievedReturn }}%
                    </span>
                    <span @class([
                        'diff',
                        'negative' => $user->_24hAchievedReturn < 0,
                        'positive' => $user->_24hAchievedReturn >= 0
                    ])>
                        <span class="value">{{ $user->_24hFormattedAchievedReturn }}%</span> afgelopen 24u
                    </span>
                </div>
            </div>

            @if($multifundParticipant)
                <hr>

                <button class="summaryButton" onclick="toggleDetails('#achieved_return')">Bekijk specificaties <i class="fa-solid fa-chevron-down fa-fw"></i></button>
            @endif
        </div>

        @if($multifundParticipant)
            <div class="details">
                @foreach($user->funds as $fund)
                    <div>
                        <h3>{{ $fund->name }}</h3>
                        <div>
                            <span class="subtotal">
                                {{ $fund->formattedAchievedReturn }}%
                            </span>
                            <span @class([
                                'diff',
                                'negative' => $fund->_24hAchievedReturn < 0,
                                'positive' => $fund->_24hAchievedReturn >= 0
                            ])>
                                <span class="value">{{ $fund->_24hFormattedAchievedReturn }}%</span> afgelopen 24u
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <div id="desktop_hr">
        <hr>
    </div>
    
    <div id="form_buttons" class="button_group">
        <hr>

        <button onclick="open_modal('bijstorten')">Bijstorten</button>

        <button onclick="open_modal('contact')" class="alt">Contact opnemen</button>

        <hr>
    </div>

    <section id="documents">

        <div class="summary clickable_on_mobile" onclick="toggleDetailsMobileOnly('#documents')">
            <h2>
                Documenten

                <button class="summaryButton">
                    <i class="fa-solid fa-chevron-down fa-fw"></i>
                </button>
            </h2>
        </div>

        <div class="details">
            @foreach($user->funds as $fund)
                @foreach($fund->factsheets as $factsheet)
                    @if ($loop->first)
                        <div>
                            <h3>{{ $fund->name }}</h3>
                            <hr>
                            <ul>
                    @endif
                                <li>
                                    <span>Week {{ $factsheet->name }}</span>
                                    <a href="{{ $factsheet->route }}" target="_blank" rel="noopener noreferrer">
                                        Bekijken<i class="fa-solid fa-arrow-right fa-fw"></i>
                                    </a>
                                </li>

                    @if($loop->iteration === 4)
                            </ul>
                        </div>
                        @break
                    @endif

                    @if ($loop->last)
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endforeach

            @foreach($user->annualFinancialOverviews as $annualFinancialOverview)
                @if ($loop->first)
                    <div>
                        <h3>Persoonlijke Documenten</h3>
                        <hr>
                        <ul class="personal-documents-list">
                @endif
                            <li class="personal-documents-list-item">
                                <span class="personal-documents-list-item-doc-title">{{ $annualFinancialOverview->name }}</span>
                                <a href="{{ $annualFinancialOverview->route }}" target="_blank" rel="noopener noreferrer">
                                    Bekijken<i class="fa-solid fa-arrow-right fa-fw"></i>
                                </a>
                            </li>
                @if ($loop->last)
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>

    </section>
    
    @foreach($user->funds as $fund)

        <section id="fund_{{ $fund->slug }}" class="fund with_details">

            <div class="summary">
                <div class="summary_inner">
                    <div class="summary clickable_on_mobile" onclick="toggleInnerDetails('#fund_{{ $fund->slug }}')">
                        <h2>
                            {{ $fund->name }}

                            <button class="summaryButton fundSummaryButton">
                                <i class="fa-solid fa-chevron-down fa-fw"></i>
                            </button>
                        </h2>
                    </div>

                    <div class="details">
                        <x-fund-plot :fund="$fund->model"/>

                        {{-- <x:chart-js-fund-chart :fund-identifier="$fund->model->id" :display-statistics=false /> --}}
                    </div>
                </div>

                <hr>
    
                <button class="summaryButton fundSummaryButton" onclick="toggleDetailsMobileOnly('#fund_{{ $fund->slug }}')">Participatie info <i class="fa-solid fa-chevron-down fa-fw"></i></button>
            </div>

            <div class="details">
                <livewire:portal.participation :fund="$fund->model" :wire:key="$fund->model->id" />
            </div>
        </section>

    @endforeach

</x-portal.portfolio-layout> 