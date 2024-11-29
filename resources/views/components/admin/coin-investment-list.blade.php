@props([
    'fund',
    'coinInvestments',
    'isDeribitConnectedToFund',
    'deribitBitCoinQty',
    'deribitEthereumQty',
    'usdcQty'
])

<table>
    <thead>
        <tr>
            <th class="align-left">Coin</th>
            <th class="align-left">Qty</th>
            <th class="align-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($isDeribitConnectedToFund)
            <tr>
                <td class="align-left">Bitcoin (Deribit)</td>
                <td class="align-left">{{ $deribitBitCoinQty }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="align-left">Ethereum (Deribit)</td>
                <td class="align-left">{{ $deribitEthereumQty }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="align-left">USDC (Deribit)</td>
                <td class="align-left">{{ $usdcQty }}</td>
                <td></td>
            </tr>
        @endif
        @forelse ($coinInvestments as $coinInvestment)
            <tr>
                <td class="align-left">{{ $coinInvestment->coin_name }}</td>
                <td class="align-left">{{ $coinInvestment->qty }}</td>
                <td class="align-right">
                    <div class="tooltip">
                        <a href="{{ route('funds.coininvestments.edit', ['fund' => $fund, 'coininvestment' => $coinInvestment]) }}"><i class="fa fa-user fa-pen"></i></a>
                        <span class="tooltiptext">edit</span>
                    </div>
                    <div class="tooltip">
                        <a href="{{ route('funds.coininvestments.destroy', ['fund' => $fund, 'coininvestment' => $coinInvestment]) }}" onclick="delete_coin_investment('{{ route('funds.coininvestments.destroy', ['fund' => $fund, 'coininvestment' => $coinInvestment]) }}', '{{ $coinInvestment->coin_name }}')"
                            ><i class="fa fa-user fa-trash"></i>
                        </a>
                        <span class="tooltiptext">delete</span>
                    </div>
                </td>
            </tr>
        @empty
            @if (!$isDeribitConnectedToFund)
                <tr>
                    <td colspan="3">No records found.</td>
                </tr>
            @endif
        @endforelse
    </tbody>

    <form id="delete_coin_investment_form" action="" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function delete_coin_investment( action, name )
        {
            event.preventDefault();

            if (confirm("Delete coin: '" + name + "'") == true)
            {
                $('#delete_coin_investment_form').attr('action', action).submit();
            } 
        }
    </script>
</table>