<x-admin.layout class="posts">
    
    <h1>Knowledge Base News Articles</h1>

    <section>

        <a class="button" href="{{ route('knowledgebase-news.create') }}">New Knowledge Base News Article</a>

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
                @forelse ($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->published ? 'Published' : 'Draft' }}</td>
                        <td>{{ $article->created_at }}</td>
                        <td class="align-left">
                            @if ($article->published)
                                {{ $article->publication_date }}
                            @endif
                        </td>
                        <td class="align-right">
                            @if($article->published)
                                <div class="tooltip">
                                    <a href="{{ route('knowledgebase-news.show', ['knowledgebase_news' => $article]) }}"><i class="fa fa-eye fa-fw"></i></a>
                                    <span class="tooltiptext">view</span>
                                </div>
                            @endif
                            <div class="tooltip">
                                <a href="{{ route('knowledgebase-news.edit', ['knowledgebase_news' => $article]) }}"><i class="fa fa-pen fa-fw"></i></a>
                                <span class="tooltiptext">edit</span>
                            </div>
                            <div class="tooltip">
                                <a href="{{ route('knowledgebase-news.destroy', ['knowledgebase_news' => $article]) }}" onclick="delete_article('{{ route('knowledgebase-news.destroy', ['knowledgebase_news' => $article]) }}', '{{ $article->title }}')"
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
            function delete_article( action, name )
            {
                event.preventDefault();

                if (confirm("Delete article: '" + name) == true)
                {
                    $('#delete_delete_form').attr('action', action).submit();
                } 
            }
        </script>

    </section>

</x-admin.layout>