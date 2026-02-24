@extends('back.layouts.app')

@section('title', 'Users')

@section('page_title', 'Users')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.user')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah User</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="userTable" :ajax="route('admin.users.index')" :header="['No', 'Nama', 'Email', 'Role', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'name',
        'email',
        'roles' => ['searchable' => false, 'orderable' => false],
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" :order="[[1, 'asc']]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data user akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.users.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#userTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            var message = 'Terjadi kesalahan saat menghapus data.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                message = xhr.responseJSON.error;
                            }
                            Swal.fire('Gagal!', message, 'error');
                        },
                    });
                }
            });
        });
    </script>
@endpush
