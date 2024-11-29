@props([
    'available_locales'
])
{{-- 
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    @foreach($available_locales as $locale_name => $available_locale)
        CKEDITOR.replace( 'content[{{ $available_locale }}]' );
    @endforeach
</script> --}}