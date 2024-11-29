<x-portal.knowledge-base-layout id="knowledgebaseNewsArticlePage" :title="$title">
    <x-portal.news-article-inline-styles
        feature_image_small_url="{{ route('kb.asset.image', ['filename' => basename($feature_image_small_url)]) }}"
        feature_image_large_url="{{ route('kb.asset.image', ['filename' => basename($feature_image_large_url)]) }}" />

    <x-slot:heading>
        <div class="heading">
            <h1>{{  $title }}</h1>

            <p class="subtitle">{{ $publicationDate }}</p>
        </div>
    </x-slot>

    <section id="blog_article">
        <div>{!! $content !!}</div>

        @if ($bottom_img_storage_path)
            <img src="{{ route('kb.asset.image', ['filename' => basename($bottom_img_storage_path)]) }}" alt="image">
        @endif

        @if ($bottom_video_storage_path)
            <x-portal.video-with-play-button videoUrl="{{ route('kb.asset.video', ['filename' => basename($bottom_video_storage_path)]) }}" videoPosterUrl="{{ $bottom_video_poster_storage_path ? route('kb.asset.image', ['filename' => basename($bottom_video_poster_storage_path)]) : '/assets/videos/previewPosterDummy.PNG' }}" />
        @endif

        @if ($attachment_url)
            <a href="{{ $attachment_url }}" target="_blank" rel="noopener noreferrer">
                Download: {{ $attachment_name }}
            </a>
        @endif
    </section>
</x-portal.knowledge-base-layout>