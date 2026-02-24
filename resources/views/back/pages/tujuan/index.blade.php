@extends('back.layouts.app')

@section('title', 'Tujuan')

@section('page_title', 'Tujuan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.tujuan.index') }}">Tujuan</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.tujuan')
            <a href="{{ route('admin.tujuan.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Tujuan</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="tujuanTable" :ajax="route('admin.tujuan.index')" :header="['No', 'Nama Tujuan', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama_tujuan',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data tujuan akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.tujuan.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#tujuanTable').DataTable().ajax.reload();
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
