@extends('back.layouts.app')

@section('title', 'Kapal')

@section('page_title', 'Kapal')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kapal.index') }}">Kapal</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.kapal')
            <a href="{{ route('admin.kapal.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Kapal</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="kapalTable" :ajax="route('admin.kapal.index')" :header="['No', 'Nama Kapal', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama_kapal',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data kapal akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.kapal.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#kapalTable').DataTable().ajax.reload();
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
