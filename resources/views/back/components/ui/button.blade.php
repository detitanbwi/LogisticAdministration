@props([
    'disabled' => false,
    'type' => 'submit',
    'href' => null,
    'variant' => 'primary',
    'size' => '',
    'class' => '',
    'block' => false,
])

@php
    $baseClass =
        'btn btn-' .
        $variant .
        ($size ? ' btn-' . $size : '') .
        ($block ? ' w-100' : '') .
        ($class ? ' ' . $class : '');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClass]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $baseClass, 'disabled' => $disabled]) }}
        @if ($type === 'submit') onclick="if(this.closest('form') && this.closest('form').checkValidity()) {
                let btn = this;
                setTimeout(function() {
                    btn.disabled = true;
                    btn.innerHTML = '<span class=\'spinner-border spinner-border-sm me-1\' role=\'status\' aria-hidden=\'true\'></span> Loading...';
                }, 50);
            }" @endif>
        {{ $slot }}
    </button>
@endif
