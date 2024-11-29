<div>
    <a class="button" href="{{ route('funds.factsheets.create', ['fund' => $fund]) }}">New Factsheet</a>

    <p class="filters">
        <label for="start_year">From year</label>
        <select wire:model="start_year" wire:change="change">
            <option value="">-</option>
            @for ($i = \Illuminate\Support\Carbon::now()->year; $i > 2000; $i--)
                <option value="{{ $i }}">
                    {{ $i }}
                </option>
            @endfor
        </select>

        <label for="start_week">Week</label>
        <select wire:model="start_week" wire:change="change">
            <option value="">-</option>
            @for ($i = 1; $i < 54; $i++)
                <option value="{{ $i }}">
                    {{ $i }}
                </option>
            @endfor
        </select>

        <label for="end_year">To year</label>
        <select wire:model="end_year" wire:change="change">
            <option value="">-</option>
            @for ($i = \Illuminate\Support\Carbon::now()->year; $i > 2000; $i--)
                <option value="{{ $i }}">
                    {{ $i }}
                </option>
            @endfor
        </select>

        <label for="end_week">Week</label>
        <select wire:model="end_week" wire:change="change">
            <option value="">-</option>
            @for ($i = 1; $i < 54; $i++)
                <option value="{{ $i }}">
                    {{ $i }}
                </option>
            @endfor
        </select>

        <x-select-results-per-page />
    </p>

    <table>
        <thead>
            <tr>
                <th class="align-left">Factsheet</th>
                <th class="align-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($factsheets as $factsheet)
                <tr>
                    <td class="align-left">
                        <a href="{{ route('factsheet', ['fund' => $fund->slug, 'year' => $factsheet->year, 'week' => $factsheet->week]) }}" target="_blank" rel="noopener noreferrer">
                            {{ $factsheet->year }} week {{ $factsheet->week }}
                        </a>
                    </td>
                    <td class="align-right">
                        <div class="tooltip">
                            <a href="{{ route('funds.factsheets.destroy', ['fund' => $fund, 'factsheet' => $factsheet]) }}" onclick="delete_factsheet('{{ route('funds.factsheets.destroy', ['fund' => $fund, 'factsheet' => $factsheet]) }}', '{{ $factsheet->year }} - {{ $factsheet->week }}')"
                                ><i class="fa fa-user fa-trash"></i>
                            </a>
                            <span class="tooltiptext">delete</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $factsheets->links('components.pagination') }}
</div>
