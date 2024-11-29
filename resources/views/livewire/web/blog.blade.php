<section>
    <div id="bloggrid">
        @foreach ($posts as $post)
            <x-web.post :post="$post" />
        @endforeach
    </div>

    {{ $posts->links('components.pagination-alt2') }}
</section>