<a class="button" href="{{ route('funds.create') }}">New Fund</a>

<table>
    <thead>
        <tr>
            <th class="align-left">Fund name</th>
            <th class="align-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($funds as $fund)
            <tr>
                <td class="align-left"><a href="{{ route('funds.show', ['fund' => $fund]) }}">{{ $fund->name }}</a></td>
                <td class="align-right">
                    <div class="tooltip">
                        <a href="{{ route('funds.show', ['fund' => $fund]) }}"><i class="fa fa-user fa-eye"></i></a>
                        <span class="tooltiptext">view</span>
                    </div>
                    <div class="tooltip">
                        <a href="{{ route('funds.destroy', ['fund' => $fund]) }}" onclick="delete_fund('{{ route('funds.destroy', ['fund' => $fund]) }}', '{{ $fund->name }}')"
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

<form id="delete_fund_form" action="" method="POST">
    @csrf
    @method('DELETE')
</form>

<script>
    function delete_fund( action, name )
    {
        event.preventDefault();

        if (confirm("Delete fund: '" + name + "' and all it's related data (factsheets, participations).") == true)
        {
            $('#delete_fund_form').attr('action', action).submit();
        } 
    }
</script>