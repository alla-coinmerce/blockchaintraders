@props([
    'fund',
    'participationInvestments'
])

<table>
    <thead>
        <tr>
            <th class="align-left">Fund</th>
            <th class="align-left">Tag</th>
            <th class="align-left">Purchase date</th>
            <th class="align-left">Qty</th>
            <th class="align-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($participationInvestments as $participationInvestment)
            <tr>
                <td class="align-left">{{ $participationInvestment->fund->name }}</td>
                <td class="align-left">{{ $participationInvestment->tag->name }}</td>
                <td class="align-left">{{ $participationInvestment->purchase_date }}</td>
                <td class="align-left">{{ $participationInvestment->qty }}</td>
                <td class="align-right">
                    <div class="tooltip">
                        <a href="{{ route('funds.participationinvestments.edit', ['fund' => $fund, 'participationinvestment' => $participationInvestment]) }}"><i class="fa fa-user fa-pen"></i></a>
                        <span class="tooltiptext">edit</span>
                    </div>
                    <div class="tooltip">
                        <a href="{{ route('funds.participationinvestments.destroy', ['fund' => $fund, 'participationinvestment' => $participationInvestment]) }}" onclick="delete_participation_investment('{{ route('funds.participationinvestments.destroy', ['fund' => $fund, 'participationinvestment' => $participationInvestment]) }}', '{{ $participationInvestment->fund->name }}')"
                            ><i class="fa fa-user fa-trash"></i>
                        </a>
                        <span class="tooltiptext">delete</span>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No records found.</td>
            </tr>
        @endforelse
    </tbody>

    <form id="delete_participation_investment_form" action="" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function delete_participation_investment( action, name )
        {
            event.preventDefault();

            if (confirm("Delete participation for " + name + ".") == true)
            {
                $('#delete_participation_investment_form').attr('action', action).submit();
            } 
        }
    </script>
</table>