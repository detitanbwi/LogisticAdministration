@props([
    'disabled' => false,
    'type' => 'text',
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'value' => null,
    'required' => false,
    'id' => null,
    'hint' => '',
    'default' => null,
])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-3 position-relative">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div @if ($type === 'password') x-data="{ show: false }" @endif class="position-relative">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) !!} type="{{ $type }}"
            @if ($type === 'password') x-bind:type="show ? 'text' : 'password'" @endif name="{{ $name }}"
            id="{{ $id }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value ?? $default) }}"
            {{ $required ? 'required' : '' }}>

        @if ($type === 'password')
            <a href="javascript:void(0);" @click="show = !show"
                class="position-absolute top-50 end-0 translate-middle-y me-3 text-secondary" style="z-index: 5;">
                <i x-bind:class="show ? 'feather-eye-off' : 'feather-eye'"></i>
            </a>
        @endif

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>
