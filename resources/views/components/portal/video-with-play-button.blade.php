@props([
    'videoUrl',
    'videoPosterUrl',
    'videoWebVttUrl',
    'controls' => true
])

<div class="videoContainer" {{ $attributes }}>
    <video
        {{ $controls ? 'controls' : '' }}
        playsInline 
        src="{{ $videoUrl }}" 
        @if (pathinfo($videoUrl, PATHINFO_EXTENSION) === 'mov')
            type="video/quicktime" 
        @else
            type="video/mp4" 
        @endif
        preload="auto" 
        @if(!empty($videoPosterUrl))
            poster="{{ $videoPosterUrl }}"
        @endif
    >
        <source src="{{ $videoUrl }}" 
            @if (pathinfo($videoUrl, PATHINFO_EXTENSION) === 'mov')
                type="video/quicktime" 
            @else
                type="video/mp4" 
            @endif>
        @if(!empty($videoWebVttUrl))
            <track src="{{ $videoWebVttUrl }}" kind="subtitles" srclang="nl" label="Nederlands">
        @endif
        Your browser does not support the video tag.
    </video>
    <img 
        @if ($controls)
            onclick="startVideo(this)"
        @endif  
            src="/assets/images/portal/knowledge_base/PlayNew.svg" alt="play icon">
</div>

<script>
    function startVideo(element)
    {
        $(element).siblings('video').first().trigger('play'); 
        $(element).hide();
    }
</script>