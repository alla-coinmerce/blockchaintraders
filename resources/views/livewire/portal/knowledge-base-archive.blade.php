<div>
    <div class="head">
       <h1>Alle updates</h1>
    
       <div class="search">
            <span class="fa fa-search"></span>
            <input type="text" name="searchInput" id="searchInput" placeholder="Zoeken" wire:model="search">
        </div>
    </div>

    <div class="archive" wire:loading.class.delay='"opacity-50'>
        @foreach ($articles as $article)
            <x-portal.news-article :article="$article" />
        @endforeach
    </div>

    {{ $articles->links('components.pagination-alt') }}
</div>
