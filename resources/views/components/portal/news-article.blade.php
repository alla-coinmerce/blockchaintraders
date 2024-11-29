<div class="blog_grid_post">
    @if ($first && !empty($videoStoragePath))
        <x-portal.video-with-play-button onclick="openPopupVideo()" :controls="false" videoUrl="{{ route('kb.asset.video', ['filename' => basename($videoStoragePath)]) }}" videoPosterUrl="{{ $bottomVideoPosterStoragePath ? route('kb.asset.image', ['filename' => basename($bottomVideoPosterStoragePath)]) : '/assets/videos/previewPosterDummy.PNG' }}" />

        @push('foot')
            <dialog id="videoPopup">
                <div class="dialog_content">
                    <span class="close" onclick="closePopupVideo()">&times;</span>
                    <x-portal.video-with-play-button id="popupVideo" videoUrl="{{ route('kb.asset.video', ['filename' => basename($videoStoragePath)]) }}" videoPosterUrl="{{ $bottomVideoPosterStoragePath ? route('kb.asset.image', ['filename' => basename($bottomVideoPosterStoragePath)]) : '/assets/videos/previewPosterDummy.PNG' }}" />
                </div>
            </dialog>

            <script>
                const dialog = document.getElementById("videoPopup");
                const video = document.getElementById("videoPopup").getElementsByTagName("video")[0];

                function openPopupVideo()
                {
                    dialog.showModal();
                }

                function closePopupVideo()
                {
                    video.pause();

                    dialog.close();
                }

                dialog.addEventListener('click', (e) => {
                    if (e.target.tagName !== 'DIALOG') //This prevents issues with forms
                        return;

                    const rect = e.target.getBoundingClientRect();

                    const clickedInDialog = (
                        rect.top <= e.clientY &&
                        e.clientY <= rect.top + rect.height &&
                        rect.left <= e.clientX &&
                        e.clientX <= rect.left + rect.width
                    );

                    if (clickedInDialog === false)
                        video.pause();
                        e.target.close();
                });
            </script>
        @endpush
    @elseif($feature_image_small_url)
        <img src="{{ route('kb.asset.image', ['filename' => basename($feature_image_small_url)]) }}" alt="featured image">
    @else
        <div></div>
    @endif

    <div class="container">
        <h2>{{ $title }}</h2>

        <p class="publication_date">{{ $publicationDate }}</p>

        <p class="excerpt">{!! $excerpt !!}</p>

        <a href="{{ route('kb.news-article', ['article' => $article]) }}">{{ __("Read more") }}...</a>
    </div>
</div>