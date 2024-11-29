<x-admin.layout>
    
    <h1>Tags</h1>

    <section>
        <a class="button" href="{{ route('tags.create') }}">New Tag</a>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Tag</th>
                    <th class="align-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $tag)
                    <tr>
                        <td class="align-left">{{ $tag->name }}</td>
                        <td class="align-right">
                            <div class="tooltip">
                                <a href="{{ route('tags.edit', ['tag' => $tag]) }}"><i class="fa fa-user fa-pen"></i></a>
                                <span class="tooltiptext">edit</span>
                            </div>
                            <div class="tooltip">
                                <a href="{{ route('tags.destroy', ['tag' => $tag]) }}" onclick="delete_tag('{{ route('tags.destroy', ['tag' => $tag]) }}', '{{ $tag->name }}')"
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

        <form id="delete_tag_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function delete_tag( action, name )
            {
                event.preventDefault();

                if (confirm("Delete tag: '" + name + "'.") == true)
                {
                    $('#delete_tag_form').attr('action', action).submit();
                } 
            }
        </script>
    </section>

</x-admin.layout>