@props([
    'disabled' => false,
    'label' => '',
    'name' => '',
    'options' => [],
    'value' => null,
    'id' => null,
    'hint' => '',
    'inline' => false,
    'type' => 'default', // 'default' or 'button'
])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-4">
    @if ($label)
        <label class="form-label mb-2">{{ $label }}</label>
    @endif

    <div class="{{ $inline ? 'd-flex flex-wrap gap-2' : '' }}">
        @foreach ($options as $optionValue => $optionLabel)
            @if ($type === 'button')
                <div class="position-relative">
                    <input type="radio" class="btn-check" name="{{ $name }}"
                        id="{{ $id }}_{{ $optionValue }}" value="{{ $optionValue }}"
                        {{ (string) old($name, $value) === (string) $optionValue ? 'checked' : '' }}
                        {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
                    <label class="btn btn-outline-primary w-100" for="{{ $id }}_{{ $optionValue }}">
                        {!! $optionLabel !!}
                    </label>
                </div>
            @else
                <div class="form-check {{ $inline ? 'form-check-inline' : '' }}">
                    <input class="form-check-input" type="radio" name="{{ $name }}"
                        id="{{ $id }}_{{ $optionValue }}" value="{{ $optionValue }}"
                        {{ (string) old($name, $value) === (string) $optionValue ? 'checked' : '' }}
                        {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
                    <label class="form-check-label" for="{{ $id }}_{{ $optionValue }}">
                        {!! $optionLabel !!}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>
