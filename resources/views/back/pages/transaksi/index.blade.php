@extends('back.layouts.app')

@section('title', 'Transaksi')

@section('page_title', 'Data Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.transaksi.index') }}">Transaksi</a></li>
@endsection

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <x-back.select2 class="dt-filter" name="bank_rekening_id" id="filterBank" label="Filter Rekening:"
                :options="['' => 'Semua Rekening'] +
                    $rekenings
                        ->mapWithKeys(function ($rek) {
                            return [
                                $rek->id =>
                                    $rek->nama_bank . ' - ' . $rek->no_rekening . ' (' . $rek->nama_pemilik . ')',
                            ];
                        })
                        ->toArray()" />
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-end mt-3 mt-md-0">
            @can('create.transaksi')
                <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary h-100">
                    <i class="feather-plus me-2"></i>
                    <span>Tambah Transaksi</span>
                </a>
            @endcan
        </div>
    </div>

    <x-back.datatable id="transaksiTable" :ajax="route('admin.transaksi.index')" :header="['No', 'Tanggal', 'Jenis', 'Kategori', 'Rekening', 'Nominal', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'tanggal',
        'jenis',
        'kategori',
        'rekening',
        'nominal',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add dt-filter class manually because component attributes conflict with class attribute
            $('#filterBank').addClass('dt-filter');

            $('#filterBank').on('change', function() {
                $('#transaksiTable').DataTable().ajax.reload();
            });
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data transaksi akan dihapus permanen dan saldo rekening akan disesuaikan kembali!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.transaksi.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#transaksiTable').DataTable().ajax.reload();
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
