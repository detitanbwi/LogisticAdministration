@extends('back.layouts.app')

@section('title', 'Invoice')
@section('page_title', 'Invoice')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">Invoice</a></li>
@endsection

@section('content')
    <style>
        .form-select.dt-filter {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            padding-right: 32px;
            /* Ensure space for the arrow */
        }

        /* Optional fade effect inside, but standard ellipsis is cleaner */
    </style>
    <div class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" class="form-select dt-filter" name="daterange" id="filterDaterange"
                placeholder="Pilih Tanggal" style="cursor: pointer; background-color: #fff; height: 38px;" readonly>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterStatus" name="status" style="width: 100%;">
                <option value="">Semua Status</option>
                <option value="Belum">Belum Bayar</option>
                <option value="Bayar">Sudah Bayar</option>
                <option value="Tahan">Tahan</option>
                <option value="Cancel">Cancel</option>
                <option value="Serahkan">Serahkan</option>
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterAsal" name="asal_id" style="width: 100%;">
                <option value="">Semua Asal</option>
                @foreach ($tujuans as $t)
                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterTujuan" name="tujuan_id" style="width: 100%;">
                <option value="">Semua Tujuan</option>
                @foreach ($tujuans as $t)
                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterPengirim" name="pengirim_id" data-placeholder="Semua Pengirim"
                style="width: 100%;">
                <option value="">Semua Pengirim</option>
                @foreach ($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterPenerima" name="penerima_id" data-placeholder="Semua Penerima"
                style="width: 100%;">
                <option value="">Semua Penerima</option>
                @foreach ($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-1">
                <select class="form-select dt-filter" id="filterJudulPrint" name="judul_print_id" style="width: 100%;">
                    <option value="">Judul Print Default</option>
                    @foreach ($judulPrints as $jp)
                        <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center p-0"
                    style="width: 38px; height: 38px;" type="button" data-bs-toggle="modal"
                    data-bs-target="#judulPrintModal">
                    <i class="feather-plus"></i>
                </button>
            </div>
        </div>

        <div class="col-md-6 mt-lg-0 mt-2">
            <div class="d-flex align-items-end h-100 gap-2">
                <button class="btn btn-light"
                    onclick="$('.dt-filter').val('').trigger('change'); $('#invoiceTable').DataTable().ajax.reload()">
                    <i class="feather-refresh-ccw me-1"></i> RESET
                </button>
                <button class="btn btn-outline-primary" id="btnPrint" onclick="printTable()">
                    <i class="feather-printer me-1"></i> PRINT
                </button>
                <button class="btn btn-outline-success" id="btnExport" onclick="exportExcel()">
                    <i class="feather-download me-1"></i> EXCEL
                </button>
                @can('create.invoice')
                    <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">
                        <i class="feather-plus me-1"></i> Buat Invoice
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-back.datatable id="invoiceTable" :ajax="route('admin.invoice.index')" :header="[
            'No',
            'No Invoice',
            'ETD',
            'Asal',
            'Tujuan',
            'Pengirim',
            'Penerima',
            'Koli',
            'Jumlah',
            'Satuan',
            'Tagihan',
            'Tanda Terima',
            'Catatan Invoice - Barang',
            'Aksi',
        ]" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'no_invoice',
            'etd' => ['searchable' => false, 'orderable' => false],
            'asal' => ['orderable' => false],
            'tujuan' => ['orderable' => false],
            'pengirim',
            'penerima',
            'koli' => ['searchable' => false, 'orderable' => false],
            'jumlah' => ['searchable' => false, 'orderable' => false],
            'satuan' => ['searchable' => false, 'orderable' => false],
            'total_tagihan' => ['searchable' => false, 'orderable' => false],
            'tanda_terima',
            'catatan_muntahan' => ['searchable' => false, 'orderable' => false],
            'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
        ]" />

    @push('modals')
        <!-- Modal Tambah Judul Print -->
        <div class="modal fade" id="judulPrintModal" tabindex="-1" aria-labelledby="judulPrintModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formJudulPrint" onsubmit="event.preventDefault(); submitJudulPrint();">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulPrintModalLabel">Tambah Judul Print</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-back.text-input name="nama" label="Nama Judul Print" placeholder="Contoh: Lampiran Rekapitulasi"
                                required />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/assets/vendors/css/select2-theme.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('back/assets/vendors/js/select2.min.js') }}"></script>
    <script>
        $(function () {
            $('#filterPengirim').select2({
                theme: 'bootstrap-5',
                placeholder: 'Semua Pengirim'
            });

            $('#filterPenerima').select2({
                theme: 'bootstrap-5',
                placeholder: 'Semua Penerima'
            });

            $('#filterJudulPrint').select2({
                theme: 'bootstrap-5',
                placeholder: 'Judul Print Default',
                minimumResultsForSearch: Infinity
            });

            $('#filterStatus').select2({
                theme: 'bootstrap-5',
                placeholder: 'Semua Status',
                minimumResultsForSearch: Infinity
            });

            $('#filterAsal').select2({
                theme: 'bootstrap-5',
                placeholder: 'Semua Asal',
                minimumResultsForSearch: Infinity
            });

            $('#filterTujuan').select2({
                theme: 'bootstrap-5',
                placeholder: 'Semua Tujuan',
                minimumResultsForSearch: Infinity
            });

            // Filter change handlers
            $('#filterStatus, #filterAsal, #filterTujuan, #filterPengirim, #filterPenerima').on('change', function () {
                $('#invoiceTable').DataTable().ajax.reload();
            });

            if ($('#filterDaterange').length) {
                $('#filterDaterange').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'MM/DD/YYYY'
                    }
                });

                $('#filterDaterange').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                    $('#invoiceTable').DataTable().ajax.reload();
                });

                $('#filterDaterange').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                    $('#invoiceTable').DataTable().ajax.reload();
                });
            }
        });

        window.printTable = function () {
            var daterange = $('#filterDaterange').val() || '';
            var status = $('#filterStatus').val() || '';
            var asal = $('#filterAsal').val() || '';
            var tujuan = $('#filterTujuan').val() || '';
            var pengirim = $('#filterPengirim').val() || '';
            var penerima = $('#filterPenerima').val() || '';
            var judul = $('#filterJudulPrint').val() || '';
            var search = $('#invoiceTable').DataTable().search() || '';

            var url = '{{ route('admin.invoice.rekap_print') }}?daterange=' + encodeURIComponent(daterange) +
                '&status=' + encodeURIComponent(status) +
                '&asal_id=' + encodeURIComponent(asal) +
                '&tujuan_id=' + encodeURIComponent(tujuan) +
                '&pengirim_id=' + encodeURIComponent(pengirim) +
                '&penerima_id=' + encodeURIComponent(penerima) +
                '&judul_print_id=' + encodeURIComponent(judul) +
                '&search=' + encodeURIComponent(search);

            window.open(url, '_blank');
        }

        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data invoice akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.invoice.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#invoiceTable').DataTable().ajax.reload();
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

        window.submitJudulPrint = function () {
            var form = $('#formJudulPrint');
            var btn = form.find('button[type="submit"]');
            var defaultText = btn.html();

            $.ajax({
                url: '{{ route('admin.judul-print.store') }}',
                type: 'POST',
                data: form.serialize() + '&_token=' + $('meta[name="csrf-token"]').attr('content'),
                beforeSend: function () {
                    btn.prop('disabled', true).html('Menyimpan...');
                },
                success: function (res) {
                    var option = new Option(res.nama, res.id, true, true);
                    $('#filterJudulPrint').append(option).trigger('change');
                    $('#judulPrintModal').modal('hide');
                    form[0].reset();
                    Swal.fire('Berhasil', 'Judul print ditambahkan', 'success');
                },
                error: function (xhr) {
                    var msg = xhr.responseJSON?.message || 'Gagal menyimpan judul';
                    Swal.fire('Error', msg, 'error');
                },
                complete: function () {
                    btn.prop('disabled', false).html(defaultText);
                }
            });
        }

        window.exportExcel = function () {
            var daterange = $('#filterDaterange').val() || '';
            var status = $('#filterStatus').val() || '';
            var asal = $('#filterAsal').val() || '';
            var tujuan = $('#filterTujuan').val() || '';
            var pengirim = $('#filterPengirim').val() || '';
            var penerima = $('#filterPenerima').val() || '';
            var judul = $('#filterJudulPrint').val() || '';
            var search = $('#invoiceTable').DataTable().search() || '';

            var url = '{{ route('admin.invoice.export') }}?daterange=' + encodeURIComponent(daterange) +
                '&status=' + encodeURIComponent(status) +
                '&asal_id=' + encodeURIComponent(asal) +
                '&tujuan_id=' + encodeURIComponent(tujuan) +
                '&pengirim_id=' + encodeURIComponent(pengirim) +
                '&penerima_id=' + encodeURIComponent(penerima) +
                '&judul_print_id=' + encodeURIComponent(judul) +
                '&search=' + encodeURIComponent(search);

            window.location.href = url;
        }
    </script>
@endpush