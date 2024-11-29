@props([
    'name',
    'label',
    'maxWidth'
])

<div class="upload_with_preview">
    {{ $label }}:
    <label for="{{ $name }}" class="button">Select file</label>
    <input 
        type="file" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="@error($name) is-invalid @enderror"
        onchange="updatePreview(this, '{{ $name }}_preview')"
        style="display: none;">

    @error($name)
        <span class="alert alert-danger">{{ $message }}</span>
    @enderror

    <button type="button" onclick="resetElement_{{ $name }}()">Remove</button>

    <div class="previewbox" style="max-width: {{  $maxWidth }};">
        <img id="{{ $name }}_preview" src="#" alt="{{ $label }}" style="display:none; max-width: 100%;"/>
        <p id="no_{{ $name }}_preview" class="preview_placeholder">Preview</p>
    </div>
</div>

<script>
    function resetElement_{{ $name }}()
    {
        $('#{{ $name }}').val("");

        $('#no_{{ $name }}_preview').show();

        $('#{{ $name }}_preview').attr("src", "#");

        $('#{{ $name }}_preview').hide();
    }
</script>