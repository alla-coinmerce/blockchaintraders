<div class="blog_grid_post">
    <img src="{{ $feature_image_small_url }}" alt="featured image">

    <p class="publication_date">{{ $publicationDate }}</p>

    <h2>{{ $title }}</h2>

    <p>{!! $excerpt !!}</p>

    <a href="{{ route('post', ['post' => $post]) }}" class="button">{{ __("Read more") }} <i class="fa fa-arrow-right fa-fw"></i></a>
</div>