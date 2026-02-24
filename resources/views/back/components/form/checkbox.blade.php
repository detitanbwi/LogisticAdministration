@props([
    'disabled' => false,
    'label' => '',
    'name' => '',
    'checked' => false,
    'value' => '1',
    'id' => null,
    'hint' => '',
])

@php
    $id = $id ?? $name;
@endphp

<div class="custom-control custom-checkbox">
    <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
        {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'custom-control-input']) }}>
    <label class="custom-control-label c-pointer" for="{{ $id }}">{{ $label }}</label>

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>
