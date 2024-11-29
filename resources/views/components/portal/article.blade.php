<x-portal.knowledge-base-layout id="knowledgebaseArticlePage" firstname="{{ $user->firstname }}" email="{{ $user->email }}" {{ $attributes }}>
    <a href="{{ $previousPage }}"><i class="fa fa-arrow-left fa-fw"></i> Ga terug</a>

    <div id="knowledgebaseArticlePageContent">
        {{ $slot }}
    </div>
</x-portal.knowledge-base-layout>