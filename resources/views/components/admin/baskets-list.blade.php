<a class="button" href="{{ route('funds.create') }}">New Basket</a>

<table>
    <thead>
        <tr>
            <th class="align-left">Basket name</th>
            <th class="align-left">Share in fund B</th>
            <th class="align-left">Share in fund A</th>
            <th class="align-right">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="align-left"><a href="">Basket A</a></td>
            <td class="align-left">10%</td>
            <td class="align-left">90%</td>
            <td class="align-right">
                <div class="tooltip">
                    <a href=""><i class="fa fa-user fa-eye"></i></a>
                    <span class="tooltiptext">view</span>
                </div>
                <div class="tooltip">
                    <a href="{" onclick=""
                        ><i class="fa fa-user fa-trash"></i>
                    </a>
                    <span class="tooltiptext">delete</span>
                </div>
            </td>
        </tr>
        <tr>
            <td class="align-left"><a href="">Basket B</a></td>
            <td class="align-left">100%</td>
            <td class="align-left">0%</td>
            <td class="align-right">
                <div class="tooltip">
                    <a href=""><i class="fa fa-user fa-eye"></i></a>
                    <span class="tooltiptext">view</span>
                </div>
                <div class="tooltip">
                    <a href="{" onclick=""
                        ><i class="fa fa-user fa-trash"></i>
                    </a>
                    <span class="tooltiptext">delete</span>
                </div>
            </td>
        </tr>
        <!-- @forelse ($funds as $fund)
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
        @endforelse -->
    </tbody>
</table>

<form id="delete_basket_form" action="" method="POST">
    @csrf
    @method('DELETE')
</form>

<script>
    function delete_basket( action, name )
    {
        event.preventDefault();

        if (confirm("Delete basket: '" + name + "' and all it's related data (participations).") == true)
        {
            $('#delete_basket_form').attr('action', action).submit();
        } 
    }
</script>