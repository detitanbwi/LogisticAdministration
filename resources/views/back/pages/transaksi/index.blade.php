@extends('back.layouts.app')

@section('title', 'Transaksi')

@section('page_title', 'Data Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.transaksi.index') }}">Transaksi</a></li>
@endsection

@section('content')
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-soft-success">
                <div class="card-body">
                    <h6 class="text-success mb-2">Total Pemasukan</h6>
                    <h4 class="mb-0 text-success" id="summary-pemasukan">Rp
                        {{ number_format($total_pemasukan, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-soft-danger">
                <div class="card-body">
                    <h6 class="text-danger mb-2">Total Pengeluaran</h6>
                    <h4 class="mb-0 text-danger" id="summary-pengeluaran">Rp
                        {{ number_format($total_pengeluaran, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-soft-primary">
                <div class="card-body">
                    <h6 class="text-primary mb-2">Saldo</h6>
                    <h4 class="mb-0 text-primary" id="summary-saldo">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-end mb-4">
        <div class="col-md-3">
            <div class="form-group mb-3">
                <label class="form-label">Range Tanggal:</label>
                <input type="text" class="form-control dt-filter" name="daterange" id="filterDate"
                    placeholder="Pilih Tanggal">
            </div>
        </div>
        <div class="col-md-3">
            <x-back.select2 class="dt-filter" name="jenis" id="filterJenis" label="Jenis Transaksi:" :options="['' => 'Semua Jenis', 'pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran']" />
        </div>
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="form-group mb-3">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                @can('create.transaksi')
                    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary w-100">
                        <i class="feather-plus me-2"></i>
                        <span>Tambah Transaksi</span>
                    </a>
                @endcan
            </div>
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
    <script>     $(document).ready(function () {         // Add dt-filter class manually because component attributes conflict with class attribute         $('#filterBank, #filterJenis').addClass('dt-filter');
             if ($('#filterDate').length) {             $('#filterDate').daterangepicker({                 autoUpdateInput: false,                 locale: {                     cancelLabel: 'Clear',                     format: 'YYYY-MM-DD'                 }             });
                 $('#filterDate').on('apply.daterangepicker', function (ev, picker) {                 $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));                 reloadTableAndSummary();             });
                 $('#filterDate').on('cancel.daterangepicker', function (ev, picker) {                 $(this).val('');                 reloadTableAndSummary();             });         }
             $('.dt-filter').on('change', function () {             reloadTableAndSummary();         });
             function reloadTableAndSummary() {             if ($.fn.DataTable.isDataTable('#transaksiTable')) {                 $('#transaksiTable').DataTable().ajax.reload();             }
                 $.ajax({                 url: '{{ route('admin.transaksi.index') }}',                 data: {                     summary: true,                     bank_rekening_id: $('#filterBank').val(),                     jenis: $('#filterJenis').val(),                     daterange: $('#filterDate').val()                 },                 success: function (res) {                     $('#summary-pemasukan').text(res.total_pemasukan);                     $('#summary-pengeluaran').text(res.total_pengeluaran);                     $('#summary-saldo').text(res.saldo);                 }             });         }     });
         $(document).on('click', '.delete-btn', function () {         var id = $(this).data('id');         Swal.fire({             title: 'Apakah anda yakin?',             text: 'Data transaksi akan dihapus permanen dan saldo rekening akan disesuaikan kembali!',             icon: 'warning',             showCancelButton: true,             confirmButtonColor: '#d33',             cancelButtonColor: '#3085d6',             confirmButtonText: 'Ya, hapus!',             cancelButtonText: 'Batal',         }).then((result) => {             if (result.value) {                 $.ajax({                     url: '{{ route('admin.transaksi.index') }}/' + id,                     type: 'DELETE',                     headers: {                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')                     },                     success: function (response) {                         Swal.fire('Terhapus!', response.success, 'success');                         $('#transaksiTable').DataTable().ajax.reload();                     },                     error: function (xhr) {                         var message = 'Terjadi kesalahan saat menghapus data.';                         if (xhr.responseJSON && xhr.responseJSON.error) {                             message = xhr.responseJSON.error;                         }                         Swal.fire('Gagal!', message, 'error');                     },                 });             }         });     });
    </script>
@endpush