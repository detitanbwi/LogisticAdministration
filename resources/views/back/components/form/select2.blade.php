@props([
    'disabled' => false,
    'label' => '',
    'name' => '',
    'placeholder' => 'Pilih...',
    'required' => false,
    'id' => null,
    'multiple' => false,
    'options' => [],
    'selected' => [],
    'hint' => '',
    'selector' => 'tag',
    'createOptionForm' => null, // URL or Identifier for the modal/collapse form
    'createOptionLabel' => 'Tambah Baru',
    'toggleType' => 'modal',
])

@php
    $id = $id ?? $name;
    $fieldName = $multiple ? $name . '[]' : $name;
    $errorName = str_replace('[]', '', $name);

    // Normalize selected to array
    if (!is_array($selected)) {
        $selected = $selected ? [$selected] : [];
    }

    // Get old values
    $oldValues = old($errorName, $selected);
    if (!is_array($oldValues)) {
        $oldValues = $oldValues ? [$oldValues] : [];
    }
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="input-group">
        <select class="form-select form-control {{ $errors->has($errorName) ? 'is-invalid' : '' }}"
            data-select2-selector="{{ $selector }}" name="{{ $fieldName }}" id="{{ $id }}"
            {{ $multiple ? 'multiple' : '' }} {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
            {{ $attributes }}>
            @if (!$multiple && $placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}"
                    {{ in_array((string) $optionValue, array_map('strval', $oldValues)) ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach

            {{ $slot }}
        </select>

        @if ($createOptionForm)
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="{{ $toggleType }}"
                data-bs-target="{{ $createOptionForm }}" aria-expanded="false" aria-controls="{{ ltrim($createOptionForm, '#') }}">
                <i class="feather-plus"></i>
            </button>
        @endif
    </div>

    @error($errorName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if ($hint)
        <div class="fs-11 text-muted mt-1">{{ $hint }}</div>
    @endif
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('back/assets/vendors/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('back/assets/vendors/css/select2-theme.min.css') }}">
        <style>
            /* Custom Fixes for Select2 Bootstrap 5 Theme */
            /* ... (existing styles) ... */
            .select2-container--bootstrap-5 .select2-selection--multiple {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                min-height: 38px;
                padding-top: 2px;
                padding-bottom: 2px;
            }

            .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                width: 100%;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            /* Fix Choice Item Styling */
            .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
                display: flex;
                align-items: center;
                position: relative;
                padding: 2px 32px 2px 8px !important;
                /* Right padding for 'x' */
                margin: 2px 4px 2px 0;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                background-color: #fff;
                color: #212529;
                font-size: 0.875rem;
            }

            /* Fix Remove 'x' Button Position */
            .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
                position: absolute !important;
                top: 50% !important;
                right: 4px !important;
                transform: translateY(-50%);
                width: auto;
                height: auto;
                border: none;
                margin: 0;
                padding: 0;
                background: transparent;
                color: #dc3545;
                font-size: 14px;
                line-height: 1;
            }

            .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove:hover {
                color: #bb2d3b;
                background: transparent;
            }

            /* Fix Search Input Field Position & Cursor */
            .select2-container--bootstrap-5 .select2-search--inline {
                flex: auto;
                /* Allow flexible width */
                margin: 0;
            }

            .select2-container--bootstrap-5 .select2-search--inline .select2-search__field {
                margin-top: 0;
                margin-bottom: 0;
                height: 28px;
                line-height: 28px;
                padding: 0 4px;
                width: auto !important;
                /* Allow Select2 to manage width */
                min-width: 5em;
                /* Ensure visible */
                max-width: 100%;
            }

            /* Ensure dropdown z-index is correct */
            .select2-container--bootstrap-5 .select2-dropdown {
                z-index: 1056;
                /* Higher than modal */
            }

            /* Fix input group with select2 */
            .input-group>.select2-container--bootstrap-5 {
                flex: 1 1 auto;
                width: 1% !important;
            }

            .input-group>.select2-container--bootstrap-5 .select2-selection {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{ asset('back/assets/vendors/js/select2.min.js') }}"></script>
        <script src="{{ asset('back/assets/vendors/js/select2-active.min.js') }}"></script>
    @endpush
@endonce
