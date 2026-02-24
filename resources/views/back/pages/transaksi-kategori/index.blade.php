@extends('back.layouts.app')

@section('title', 'Kategori Transaksi')

@section('page_title', 'Kategori Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.transaksi-kategori.index') }}">Kategori Transaksi</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.kategori_keuangan')
            <a href="{{ route('admin.transaksi-kategori.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Kategori</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="transaksiKategoriTable" :ajax="route('admin.transaksi-kategori.index')" :header="['No', 'Nama Kategori', 'Tipe Kategori', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama',
        'kategori',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data kategori akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.transaksi-kategori.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#transaksiKategoriTable').DataTable().ajax.reload();
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
