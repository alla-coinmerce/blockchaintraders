@props([
    'label',
    'value'
])

<div class="item">
    <h3>{{ $label }}</h3>

    <p class="with_left_border">{{ $value }}%</p>
</div>