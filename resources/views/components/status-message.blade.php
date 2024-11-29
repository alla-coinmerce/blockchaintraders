@if (session('status'))
    <div class="status_message">
        {{ session('status') }}
    </div>
@endif