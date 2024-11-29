@props([
    'stars',
    'addHalfStar' => false,
    'title',
    'avatarUrl',
    'name'
])

<div class="review">
    <div class="stars">
        @for ($i = 0; $i < $stars; $i++)
            <img src="/assets/images/knowledge_base_landing/star.svg" alt="star">
        @endfor

        @if ($addHalfStar)
            <img src="/assets/images/knowledge_base_landing/half-star.svg" alt="star">
        @endif
    </div>

    <h4>{{ $title }}</h4>

    <p>{{ $slot }}</p>

    <div class="foot">
        <img src="{{ $avatarUrl }}" alt="avatar">
        <span>{{ $name }}</span>
    </div>
</div>