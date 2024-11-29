<div>
    @inject('carbon', 'Illuminate\Support\Carbon')

    <a class="button" href="{{ route('funds.fundvalues.create', ['fund' => $fund]) }}">New Fund Value</a>
    <button class="button" wire:click="export">Export to CSV</button>

    <p class="filters">
        <label for="start_date">From</label>
        <input wire:model="start_date" wire:change="change" type="date">

        <label for="end_date">To</label>
        <input wire:model="end_date" wire:change="change" type="date">

        <x-select-results-per-page />
    </p>

    <table>
        <thead>
            <tr>
                <th class="align-left">Date (GMT)</th>
                <th class="align-left">Date (Europe/Amsterdam)</th>
                <th class="align-right">Euros</th>
                <th class="align-right">USD</th>
                <th class="align-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fundValues as $fundvalue)
                <tr>
                    <td class="align-left">{{ $carbon->parse($fundvalue->date_time)->format('Y-m-d H:i') }}</td>
                    <td class="align-left">{{ $carbon->parse($fundvalue->date_time)->setTimezone('Europe/Amsterdam')->format('Y-m-d H:i') }}</td>
                    <td class="align-right">{{ $fundvalue->display_value_euros }}</td>
                    <td class="align-right">{{ $fundvalue->display_value_dollars }}</td>
                    <td class="align-right">
                        <div class="tooltip">
                            <a href="{{ route('funds.fundvalues.edit', ['fund' => $fund, 'fundvalue' => $fundvalue]) }}"><i class="fa fa-user fa-pen"></i></a>
                            <span class="tooltiptext">edit</span>
                        </div>
                        <div class="tooltip">
                            <a href="{{ route('funds.fundvalues.destroy', ['fund' => $fund, 'fundvalue' => $fundvalue]) }}" onclick="delete_fundvalue('{{ route('funds.fundvalues.destroy', ['fund' => $fund, 'fundvalue' => $fundvalue]) }}', '{{ $fundvalue->date }}')"
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
    </table>

    {{ $fundValues->links('components.pagination') }}

</div>