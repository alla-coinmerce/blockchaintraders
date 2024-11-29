<section>
    <h2>
        Deribit investments
        @if ($isConnectedToFund)
            ({{ $fundName }})
        @endif
    </h2>

    <table>
        <thead>
            <tr>
                <th class="align-left">Coin</th>
                <th class="align-left">Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="align-left">Bitcoin</th>
                <td class="align-left">{{ $deribitBitCoinQty }}</td>
            </tr>
            <tr>
                <th class="align-left">Ethereum</th>
                <td class="align-left">{{ $deribitEthereumQty }}</td>
            </tr>
            <tr>
                <th class="align-left">USDC</th>
                <td class="align-left">{{ $usdcQty }}</td>
            </tr>
        </tbody>
    </table>

    @if ($isConnectedToFund)
        <button class="button" onclick="delete_deribit_fund_connection()">Unassign from fund</button>

        <form id="deribit_disconnect_form" method="POST" action="{{ route('deribit.destroy') }}">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function delete_deribit_fund_connection()
            {
                event.preventDefault();

                if (confirm("Disconnect deribit from {{ $fundName }}?") == true)
                {
                    $('#deribit_disconnect_form').submit();
                } 
            }
        </script>
    @else
        <a href="{{ route('deribit.create') }}" class="button">Assign to fund</a>
    @endif
</section>
