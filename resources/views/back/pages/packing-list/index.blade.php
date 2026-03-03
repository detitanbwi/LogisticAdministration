@extends('back.layouts.app')

@section('title', 'Packing List')

@section('page_title', 'Packing List')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.packing-list.index') }}">Packing List</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.container')
            <a href="{{ route('admin.packing-list.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Packing List</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="containerTable" :ajax="route('admin.packing-list.index')" :header="['No', 'Nomor Container/Seal', 'Pelabuhan Asal', 'Pelabuhan Tujuan', 'ETD', 'Jumlah Invoice', 'Aksi']" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'nomor_container',
            'pelabuhan_asal' => ['name' => 'asal.nama_tujuan'],
            'pelabuhan_tujuan' => ['name' => 'tujuan.nama_tujuan'],
            'etd' => ['name' => 'etd'],
            'jumlah_invoice' => ['searchable' => false, 'orderable' => false],
            'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
        ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data container akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.packing-list.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#containerTable').DataTable().ajax.reload();
                        },
                        error: function (xhr) {
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