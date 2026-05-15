@extends('back.layouts.app')

@section('title', isset($role) ? 'Edit Role' : 'Tambah Role')

@section('page_title', isset($role) ? 'Edit Role' : 'Tambah Role')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item">{{ isset($role) ? 'Edit' : 'Tambah' }}</li>
@endsection

@php
    $rolePermissions = $rolePermissions ?? [];
@endphp

@section('content')
    <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
        @csrf
        @if (isset($role))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-lg-12">
                {{-- Section 1: Nama Role --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Role</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-back.text-input label="Nama Role" name="name" placeholder="Masukkan nama role"
                                    :value="$role->name ?? ''" :required="true" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Assign Permission --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Assign Permission</h5>
                        <div class="card-header-action">
                            <x-back.checkbox id="selectAll" label="Select All" />
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($groupedPermissions as $resource => $permissions)
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold text-dark text-uppercase mb-0">
                                        <i class="feather-folder me-2"></i>{{ $resource }}
                                    </h6>
                                    <x-back.checkbox id="selectResource_{{ $resource }}" class="select-resource"
                                        label="Select All" data-resource="{{ $resource }}" />
                                </div>
                                <div class="row g-3">
                                    @foreach ($permissions as $permission)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <x-back.checkbox id="perm_{{ $permission['id'] }}" name="permissions[]"
                                                :value="$permission['name']" :label="str_replace('_', ' ', ucfirst($permission['action']))" :checked="in_array(
                                                    $permission['name'],
                                                    old('permissions', $rolePermissions),
                                                )"
                                                class="permission-checkbox" data-resource="{{ $resource }}" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        @error('permissions')
                            <div class="text-danger fs-11 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <x-back.button variant="light-brand" :href="route('admin.roles.index')">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </x-back.button>
                        <x-back.button type="submit">
                            <i class="feather-save me-2"></i>
                            <span>{{ isset($role) ? 'Perbarui' : 'Simpan' }}</span>
                        </x-back.button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to update "Select All per Resource" checkbox state
            function updateResourceCheckbox(resource) {
                var $permissions = $('.permission-checkbox[data-resource="' + resource + '"]');
                var total = $permissions.length;
                var checked = $permissions.filter(':checked').length;

                // Only check if all are checked and there is at least one permission
                $('#selectResource_' + resource).prop('checked', total === checked && total > 0);

                // Also update the indeterminate state if some are checked
                $('#selectResource_' + resource).prop('indeterminate', checked > 0 && checked < total);
            }

            // Function to update "Select All Global" checkbox state
            function updateSelectAll() {
                var total = $('.permission-checkbox').length;
                var checked = $('.permission-checkbox:checked').length;

                $('#selectAll').prop('checked', total === checked && total > 0);
                $('#selectAll').prop('indeterminate', checked > 0 && checked < total);
            }

            // 1. Handle Global "Select All" click
            $(document).on('change', '#selectAll', function() {
                var isChecked = $(this).is(':checked');
                $('.permission-checkbox').prop('checked', isChecked).trigger(
                'change.permission'); // Trigger custom event to avoid recursive loops if needed
                $('.select-resource').prop('checked', isChecked);

                // Reset indeterminate states
                $('#selectAll').prop('indeterminate', false);
                $('.select-resource').prop('indeterminate', false);
            });

            // 2. Handle Resource "Select All" click
            $(document).on('change', '.select-resource', function() {
                var resource = $(this).data('resource');
                var isChecked = $(this).is(':checked');

                $('.permission-checkbox[data-resource="' + resource + '"]').prop('checked', isChecked);
                updateSelectAll();
                $(this).prop('indeterminate', false);
            });

            // 3. Handle Individual Permission click
            $(document).on('change', '.permission-checkbox', function(e) {
                // Prevent infinite loops if simplified
                var resource = $(this).data('resource');
                updateResourceCheckbox(resource);
                updateSelectAll();
            });

            // Initial State Check
            $('.select-resource').each(function() {
                var resource = $(this).data('resource');
                updateResourceCheckbox(resource);
            });
            updateSelectAll();
        });
    </script>
@endpush
