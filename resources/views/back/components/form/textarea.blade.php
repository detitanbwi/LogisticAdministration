@props([
    'disabled' => false,
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'id' => null,
    'rows' => 3,
    'hint' => '',
])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-4">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) !!} name="{{ $name }}" id="{{ $id }}"
        rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>
