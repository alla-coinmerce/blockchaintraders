<x-admin.layout class="posts">
    
    <h1>Posts</h1>

    <section>

        <a class="button" href="{{ route('posts.create') }}">New Post</a>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Title</th>
                    <th class="align-left">Status</th>
                    <th class="align-left">Created at</th>
                    <th class="align-left">Publication date</th>
                    <th class="align-right actions">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->published ? 'Published' : 'Draft' }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td class="align-left">
                            @if ($post->published)
                                {{ $post->publication_date }}
                            @endif
                        </td>
                        <td class="align-right">
                            @if($post->published)
                                <div class="tooltip">
                                    <a href="{{ route('post', ['post' => $post]) }}"><i class="fa fa-eye fa-fw"></i></a>
                                    <span class="tooltiptext">view</span>
                                </div>
                            @endif
                            <div class="tooltip">
                                <a href="{{ route('posts.edit', ['post' => $post]) }}"><i class="fa fa-pen fa-fw"></i></a>
                                <span class="tooltiptext">edit</span>
                            </div>
                            <div class="tooltip">
                                <a href="{{ route('posts.destroy', ['post' => $post]) }}" onclick="delete_post('{{ route('posts.destroy', ['post' => $post]) }}', '{{ $post->title }}')"
                                    ><i class="fa fa-trash fa-fw"></i>
                                </a>
                                <span class="tooltiptext">delete</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <form id="delete_delete_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function delete_post( action, name )
            {
                event.preventDefault();

                if (confirm("Delete post: '" + name) == true)
                {
                    $('#delete_delete_form').attr('action', action).submit();
                } 
            }
        </script>

    </section>

</x-admin.layout>