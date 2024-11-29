<x-web.layout id="postpage">

    @push('meta')
        <meta name="keywords" content="{{  $keywords }}">
        <meta name="description" content="{{ $description }}">
    @endpush

    @push('styles')
        <style>
            #postpage header {
                    background: url({{ $feature_image_small_url }}) center no-repeat;
                    background-color: #0C0C16;
                    background-size: 80%;
                }

            @media (min-width: 700px) {
                #postpage header {
                    background: url({{ $feature_image_large_url }}) center no-repeat;
                    background-color: #0C0C16;
                    background-size: 70%;
                }
            }
        </style>
    @endpush

    <x-slot:title>
        {{  $metaTitle }}
    </x-slot>
    
    <x-slot:heading>
        <div class="heading">
            <h1>{{  $title }}</h1>

            <p class="subtitle">{{ $publicationDate }}</p>
        </div>
    </x-slot>

    <p style="color: white; text-align: center; font-size: 1.5rem; margin: 0; padding: 0.5rem; background-color: orange; width: 100%;">PREVIEW</p>

    <section id="blog_article">    
        <div>{!! $content !!}</div>

        @if ($bottom_img_storage_path)
            <img src="{{ $bottom_img_storage_path }}" alt="image">
        @endif

        @if ($bottom_video_storage_path)
            <video controls id="post_video">
                <source src="{{ $bottom_video_storage_path }}" id="post_video_source">
                Your browser does not support HTML5 video.
            </video>
        @endif

        @if ($attachment_url)
            <a href="{{ $attachment_url }}" target="_blank" rel="noopener noreferrer">
                Download: {{ $attachment_name }}
            </a>
        @endif
    </section>

    <section id="blog_contact">
        <h2>{{  __("Interested in investing with BlockchainTraders?") }}</h2>

        <p>{{  __("Contact us to look at the possibilities.") }}</p>

        <button onclick="open_modal('contact')">{{  __("Get in touch") }}</button>
    </section>

</x-web.layout>