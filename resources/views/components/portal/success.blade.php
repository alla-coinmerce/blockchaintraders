@props(['modal_id'])

<div id="form_success">
    <i class="fa-solid fa-circle-check fa-4x"></i>

    <h1>{{ __("Thank you!") }}</h1>

    <p>{{ __("We have received your request and will contact you as soon as possible.") }}</p>

    <button onclick="close_modal('{{ $modal_id }}')">Scherm sluiten</button>
</div>