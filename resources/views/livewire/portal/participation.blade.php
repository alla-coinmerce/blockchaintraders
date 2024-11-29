<div>
    <table>
        <tbody>
            @if ( $tag !== '-')
            <tr>
                <th class="align-left">{{ $tag }}</th>
                <td></td>
            </tr>
            @endif
            <tr>
                <th class="align-left">Aanschaf opvolg nummer:</th>
                <td>{{ $sequenceNumber }}</td>
            </tr>
            <tr>
                <th class="align-left">Aanschaf datum:</th>
                <td>{{ $purchaseDate }}</td>
            </tr>
            <tr>
                <th class="align-left">Aangeschafte participaties:</th>
                <td>{{ $qty }}</td>
            </tr>
            <tr>
                <th class="align-left">Tegen aankoopwaarde:</th>
                <td>€ {{ $formattedPurchaseValueEuros }}</td>
            </tr>
            <tr>
                <th class="align-left">Op datum:</th>
                <td>{{ $lastFundValueDate }}</td>
            </tr>
            <tr>
                <th class="align-left">is de waarde:</th>
                <td>€ {{ $formattedCurrentValueEuros }}</td>
            </tr>
            <tr>
                <th class="align-left">Totale waarde:</th>
                <td>€ {{ $formattedTotalCurrentValueEuros }}</td>
            </tr>
            <tr>
                <th class="align-left">Behaald rendement:</th>
                <td>{{ $formattedAchievedReturn }}%</td>
            </tr>
        </tbody>
        <tfoot>
            @if ( $tag !== '-')
            <tr>
                <th class="align-left">Totale waarde {{ $tag }}</th>
                <td>€ {{ $tagFormattedTotalCurrentValueEuros }}</td>
            </tr>
            @endif
            <tr>
                <th class="align-left">Totale waarde alle participaties:</th>
                <td class="align-left">€ {{ $formattedTotalCurrentValueEurosAllParticipations }}</td>
            </tr>
        </tfoot>
    </table>

    {{ $participations->links('components.pagination-alt') }}
</div>