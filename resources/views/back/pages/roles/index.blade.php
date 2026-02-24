@extends('back.layouts.app')

@section('title', 'Roles')

@section('page_title', 'Roles')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.role')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Role</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="roleTable" :ajax="route('admin.roles.index')" :header="['No', 'Nama Role', 'Jumlah Permission', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'name',
        'permissions_count' => ['searchable' => false, 'orderable' => false],
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" :order="[[1, 'asc']]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data role akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.roles.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#roleTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                'error');
                        },
                    });
                }
            });
        });
    </script>
@endpush
