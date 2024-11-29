<div id="{{ $id }}" class="modal">
    <div class="modal_content">
        <span class="close" onclick="close_modal('{{ $id }}')">&times;</span>
        {{ $slot }}
    </div>
</div>