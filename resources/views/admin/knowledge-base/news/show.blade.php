<x-portal.knowledge-base-layout id="knowledgebaseNewsArticlePage" :firstname="$user->firstname" :email="$user->email" :title="$title">
    <x-portal.news-article-inline-styles
        feature_image_small_url="{{ route('admin.kb.asset.image', ['filename' => basename($feature_image_small_url)]) }}"
        feature_image_large_url="{{ route('admin.kb.asset.image', ['filename' => basename($feature_image_large_url)]) }}" />

    <x-slot:heading>
        <div class="heading">
            <h1>{{  $title }}</h1>

            <p class="subtitle">{{ $publicationDate }}</p>
        </div>
    </x-slot>

    <p style="color: white; text-align: center; font-size: 1.5rem; margin: 0; padding: 0.5rem; background-color: orange; width: 100%; height: 30px;">PREVIEW</p>

    <section id="blog_article">
        <div>{!! $content !!}</div>

        @if ($bottom_img_storage_path)
            <img src="{{ route('admin.kb.asset.image', ['filename' => basename($bottom_img_storage_path)]) }}" alt="image">
        @endif

        @if ($bottom_video_storage_path)
            <video controls id="post_video">
                <source src="{{ route('admin.kb.asset.video', ['filename' => basename($bottom_video_storage_path)]) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif

        @if ($attachment_url)
            <a href="{{ route('admin.kb.asset.download', ['filename' => basename($attachment_url)]) }}" target="_blank" rel="noopener noreferrer">
                Download: {{ $attachment_name }}
            </a>
        @endif
    </section>
</x-portal.knowledge-base-layout>