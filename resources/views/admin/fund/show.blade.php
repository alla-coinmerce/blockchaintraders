<x-admin.layout>

    <h1>{{ $fund->name }}</h1>
    
    <section>
        <table>
            <tbody>
                <tr>
                    <th>Name:</th>
                    <td>{{ $fund->name }}</td>
                </tr>
                <tr>
                    <th>Public:</th>
                    <td>{{ $fund->public ? 'Yes' : 'No' }}</td>
                </tr>
                @if($fund->public)
                    <tr>
                        <th>Registration form url:</th>
                        <td>{{ route('registrationform', ['fund' => $fund]) }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Start date</th>
                    <td>
                        @if ($fund->startFundValue)
                            {{ $fund->startFundValue->date }}
                        @elseif (!($fund->fundValues->isEmpty()))
                            {{ $fund->fundValues->sortBy('date')->first()->date }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Auto update</th>
                    <td>{{ $fund->auto_update_enabled ? 'Enabled' : 'Disabled' }}</td>
                </tr>
                <tr>
                    <th>Extrapolate during weekend</th>
                    <td>{{ $fund->extrapolate_enabled ? 'Enabled' : 'Disabled' }}</td>
                </tr>
                <tr>
                    <th>Extrapolation factor</th>
                    <td>{{ $fund->extrapolation_factor ? $fund->extrapolation_factor : '' }}</td>
                </tr>
            </tbody>
        </table>

        <a class="button" href="{{ route('funds.edit', ['fund' => $fund]) }}">Edit</a> 
    </section>

    <section>
        <h2>Factsheets</h2>

        <livewire:factsheets :fund="$fund"/>

        <form id="delete_factsheet_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    
        <script>
            function delete_factsheet( action, name )
            {
                event.preventDefault();
    
                if (confirm("Delete factsheet of: '" + name + "'") == true)
                {
                    $('#delete_factsheet_form').attr('action', action).submit();
                } 
            }
        </script>
    </section>

    <section id="investments">
        <h2>Investments</h2>

        <div id="coin_investments">
            <h3>Coins</h3>

            <a class="button" href="{{ route('funds.coininvestments.create', ['fund' => $fund]) }}">New Coin</a>

            <x-admin.coin-investment-list 
                :fund="$fund" 
                :coinInvestments="$fund->coinInvestments"
                :isDeribitConnectedToFund="$isDeribitConnectedToFund"
                :deribitBitCoinQty="$deribitBitCoinQty"
                :deribitEthereumQty="$deribitEthereumQty"
                :usdcQty="$usdcQty"
                />
        </div>

        <div id="participation_investments">
            <h3>Funds</h3>

            <a class="button" href="{{ route('funds.participationinvestments.create', ['fund' => $fund]) }}">New Participation</a>

            <x-admin.participation-investment-list :fund="$fund" :participationInvestments="$fund->participationInvestments" />
        </div>
    </section>

    <section>
        <h2>Day value</h2>
    
        {{-- <x-fund-plot :fund="$fund"/> --}}
        <x:chart-js-fund-chart :fund-identifier="$fund->id" />

        <livewire:fund-values :fund="$fund" />

        <form id="delete_fundvalue_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    
        <script>
            function delete_fundvalue( action, name )
            {
                event.preventDefault();
    
                if (confirm("Delete day value of: '" + name + "'") == true)
                {
                    $('#delete_fundvalue_form').attr('action', action).submit();
                } 
            }
        </script>
    
    </section>

    <section>
        <h2>Participants</h2>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Participant</th>
                    <th class="align-right">Qty</th>
                    <th class="align-right">Euros</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($participants as $participant)
                    <tr>
                        <td class="align-left">
                            <a href="{{ $participant->route }}">
                                {{ $participant->name }}
                            </a>
                        </td>
                        <td class="align-right">{{ $participant->participationsQtyForFund }}</td>
                        <td class="align-right">€{{ $participant->totalValueEuroCents }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="align-left">Total</th>
                    <td class="align-right">{{ $totalQty }}</td>
                    <td class="align-right">€{{ $totalEuros }}</td>
                </tr>
            </tfoot>
        </table>
    </section>

</x-admin.layout>