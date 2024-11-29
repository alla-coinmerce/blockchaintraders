<x-web.layout id="postpage">

    @push('meta')
        <meta name="keywords" content="{{  $keywords }}">
        <meta name="description" content="{{ $description }}">
        <meta property="og:image" content="{{ url($feature_image_large_url) }}" />
    @endpush

    @push('styles')
        <style>
            #postpage header {
                    background: 
                        /* Top overlay */
                        radial-gradient(circle at bottom, rgba(7,28,48,0) 0%, rgba(12,12,22,0.94) 70%),
                        linear-gradient(rgba(27,26,30,0.32) 0%, rgba(27,26,30,0.32) 100%),
                        url({{ $feature_image_small_url }}) center no-repeat;
                    background-color: #0C0C16;
                    background-size: 100%, 100%, 100%;
                }

            @media (min-width: 700px) {
                #postpage header {
                    width: 75%;
                    background: 
                        /* Top overlay */
                        radial-gradient(circle at bottom, rgba(7,28,48,0) 0%, rgba(12,12,22,0.94) 100%),
                        linear-gradient(rgba(27,26,30,0.32) 0%, rgba(27,26,30,0.32) 100%),
                        url({{ $feature_image_large_url }}) center no-repeat;
                    background-color: #0C0C16;
                    background-size: 100%, 100%, 100%;
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
        <h2>{{  __("Invest with BlockchainTraders?") }}</h2>

        <p>{{  __("Contact us to explore the possibilities.") }}</p>

        <button onclick="open_modal('contact')">{{  __("Get in touch") }}</button>
    </section>

</x-web.layout>