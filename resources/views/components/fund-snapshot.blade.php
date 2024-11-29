@props([
    'fundSnapshot'
])

<div class="fundSnapshot">
    <div class="fundInvestmentsSnapshot">
        <div class="coinInvestmentsSnapshot">
            <h2>Coin investments</h2>

            <table>
                <thead>
                    <tr>
                        <th class="align-left">Coin</th>
                        <th class="align-left">Qty</th>
                        <th class="align-right">Value</th>
                        <th class="align-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fundSnapshot->coinInvestmentsSnapshot()->coinInvestmentSnapshots() as $coinInvestmentSnapshot)
                        <tr>
                            <td class="align-left">
                                {{ $coinInvestmentSnapshot->coinName() }}
                                @if (!empty($coinInvestmentSnapshot->origin()))
                                    ({{ $coinInvestmentSnapshot->origin() }})
                                @endif
                            </td>
                            <td class="align-left">{{ $coinInvestmentSnapshot->qty() }}</td>
                            <td class="align-right">{{ $coinInvestmentSnapshot->formattedCoinValueInEuros() }}</td>
                            <td class="align-right">{{ $coinInvestmentSnapshot->formattedInvestmentValueInEuros() }}</td>
                        </tr>

                        @if ($loop->last)
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="align-left" colspan="3">Total</td>
                                    <td class="align-right">{{ $fundSnapshot->coinInvestmentsSnapshot()->formattedTotalCoinInvestmentsValueInEuros() }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    @empty
                            <tr><td colspan="4">No coin investments</td></tr>
                        </tbody>
                    @endforelse
            </table>
        </div>

        <div class="fundParticipationsSnapshot">
            <h2>Fund Participation investments</h2>

            <table>
                <thead>
                    <tr>
                        <th class="align-left">Fund</th>
                        <th class="align-left">Qty</th>
                        <th class="align-left">Purchase date</th>
                        <th class="align-right">Value</th>
                        <th class="align-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fundSnapshot->participationInvestmentsSnapshot()->participationInvestmentSnapshots() as $participationInvestmentSnapshot)
                        <tr>
                            <td class="align-left">{{ $participationInvestmentSnapshot->fundName() }}</td>
                            <td class="align-left">{{ $participationInvestmentSnapshot->qty() }}</td>
                            <td class="align-left">{{ $participationInvestmentSnapshot->purchaseDate() }}</td>
                            <td class="align-right">{{ $participationInvestmentSnapshot->formattedParticipationValueInEuros() }}</td>
                            <td class="align-right">{{ $participationInvestmentSnapshot->formattedInvestmentValueInEuros() }}</td>
                        </tr>
        
                        @if ($loop->last)
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="align-left" colspan="4">Total</th>
                                    <td class="align-right">{{ $fundSnapshot->participationInvestmentsSnapshot()->formattedTotalParticipationInvestmentsValueInEuros() }}</td>
                                </tr>
                            </tfoot> 
                        @endif
                    @empty
                            <tr><td colspan="4">No fund participations</td></tr>
                        </tbody>
                    @endforelse
            </table>
        </div>
    </div>

    <div>
        <h2>Fund value</h2>
        <table>
            <tbody>
                <tr>
                    <th class="align-left">Total invested value</th>
                    <td class="align-right">{{ $fundSnapshot->formattedTotalInvestedValueInEuros() }}</td>
                </tr>
                <tr>
                    <th class="align-left">Number of participations</th>
                    <td class="align-right">{{ $fundSnapshot->numberOfParticipations() }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="align-left">Fund value</th>
                    <td class="align-right">{{ $fundSnapshot->formattedFundValueInEuros() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>