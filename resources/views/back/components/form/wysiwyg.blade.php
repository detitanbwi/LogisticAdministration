@props([
    'disabled' => false,
    'label' => '',
    'name' => '',
    'value' => null,
    'id' => null,
    'placeholder' => '',
    'required' => false,
    'hint' => '',
])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-4" wire:ignore>
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <div id="{{ $id }}_editor" style="height: 200px;">{!! old($name, $value) !!}</div>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}">

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('back/assets/vendors/css/quill.min.css') }}">
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ asset('back/assets/vendors/js/quill.min.js') }}"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('{{ $id }}_editor')) {
                var quill = new Quill('#{{ $id }}_editor', {
                    theme: 'snow',
                    placeholder: '{{ $placeholder }}',
                    readOnly: {{ $disabled ? 'true' : 'false' }}
                });

                quill.on('text-change', function() {
                    document.getElementById('{{ $id }}').value = quill.root.innerHTML;
                });

                // Set initial value if not already set by innerHTML (Quill might strip some tags so be careful)
                // But we put it in the div so Quill should pick it up.
            }
        });
    </script>
@endpush
