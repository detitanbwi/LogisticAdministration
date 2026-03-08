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
    <div class="d-flex align-items-center mb-4 flex-wrap gap-2">
        <div class="input-group" style="width: 200px;">
            <span class="input-group-text"><i class="feather-calendar"></i></span>
            <input type="text" class="form-control text-center dt-filter" name="daterange" id="filterDaterange"
                placeholder="Pilih Tanggal">
        </div>
        <select class="form-select dt-filter" id="filterStatus" name="status" style="width: 130px;">
            <option value="">Semua Status</option>
            <option value="Belum">Belum</option>
            <option value="Bayar">Bayar</option>
            <option value="Tahan">Tahan</option>
            <option value="Cancel">Cancel</option>
            <option value="Serahkan">Serahkan</option>
        </select>
        <select class="form-select dt-filter" id="filterAsal" name="asal_id" style="width: 140px;">
            <option value="">Semua Asal</option>
            @foreach ($tujuans as $t)
                <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
            @endforeach
        </select>
        <select class="form-select dt-filter" id="filterTujuan" name="tujuan_id" style="width: 150px;">
            <option value="">Semua Tujuan</option>
            @foreach ($tujuans as $t)
                <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
            @endforeach
        </select>
        <select class="form-select dt-filter" id="filterPengirim" name="pengirim_id" style="width: 180px;">
            <option value="">Semua Pengirim</option>
            @foreach ($customers as $c)
                <option value="{{ $c->id }}">{{ $c->nama }}</option>
            @endforeach
        </select>

        <div class="d-flex gap-2">
            <div class="input-group" style="width: 210px;">
                <select class="form-select dt-filter" id="filterJudulPrint" name="judul_print_id">
                    <option value="">Judul Print Default</option>
                    @foreach ($judulPrints as $jp)
                        <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                    data-bs-target="#judulPrintModal">
                    <i class="feather-plus"></i>
                </button>
            </div>
            <button class="btn btn-light"
                onclick="$('.dt-filter').val(''); $('#invoiceTable').DataTable().ajax.reload()">Reset</button>
            <button class="btn btn-outline-primary" id="btnPrint" onclick="printTable()">
                <i class="feather-printer me-1"></i> Print
            </button>
            <button class="btn btn-outline-success" id="btnExport" onclick="exportExcel()">
                <i class="feather-download me-1"></i> Excel
            </button>
            @can('create.invoice')
                <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-1"></i> Buat Invoice
                </a>
            @endcan
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
            'Tagihan',
            'Tanda Terima',
            'Catatan',
            'Aksi',
        ]" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'no_invoice',
            'etd' => ['searchable' => false],
            'asal' => ['searchable' => false, 'orderable' => false],
            'tujuan' => ['searchable' => false, 'orderable' => false],
            'pengirim',
            'penerima',
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

@push('scripts')
    <script>
        $(function () {
            // Filter change handlers
            $('#filterStatus, #filterAsal, #filterTujuan, #filterPengirim').on('change', function () {
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
            var table = $('#invoiceTable').DataTable();
            var printWindow = window.open('', '_blank');
            var rows = '';

            table.rows({
                search: 'applied'
            }).every(function () {
                var data = this.data();
                rows += '<tr>' +
                    '<td>' + data.DT_RowIndex + '</td>' +
                    '<td>' + data.no_invoice + '</td>' +
                    '<td>' + data.etd + '</td>' +
                    '<td>' + data.pengirim + '</td>' +
                    '<td>' + data.penerima + '</td>' +
                    '<td>' + data.total_tagihan + '</td>' +
                    '<td>' + (data.tanda_terima ? data.tanda_terima : '-') + '</td>' +
                    '</tr>';
            });

            var filterInfo = '';
            var asal = $('#filterAsal option:selected').text();
            var tujuan = $('#filterTujuan option:selected').text();
            if ($('#filterAsal').val()) filterInfo += '<p><strong>Asal:</strong> ' + asal + '</p>';
            if ($('#filterTujuan').val()) filterInfo += '<p><strong>Tujuan:</strong> ' + tujuan + '</p>';
            if ($('#filterDaterange').val()) filterInfo += '<p><strong>Periode:</strong> ' + $('#filterDaterange').val() +
                '</p>';

            printWindow.document.write(`
                                                                        <html>
                                                                        <head>
                                                                            <title>Rekapitulasi Invoice</title>
                                                                            <style>
                                                                                body { font-family: Arial, sans-serif; font-size: 11pt; margin: 20px; }
                                                                                h2 { text-align: center; margin-bottom: 5px; }
                                                                                .filter-info { margin-bottom: 15px; }
                                                                                .filter-info p { margin: 2px 0; font-size: 10pt; }
                                                                                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                                                                                th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; font-size: 10pt; }
                                                                                th { background-color: #f0f0f0; font-weight: bold; }
                                                                                @media print { body { margin: 0; } }
                                                                            </style>
                                                                        </head>
                                                                        <body>
                                                                            <h2>Rekapitulasi Invoice</h2>
                                                                            <h4 style="text-align:center; margin-top:0;">PT. SINAR CEMARA JAYA</h4>
                                                                            <div class="filter-info">${filterInfo}</div>
                                                                            <table>
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>No</th>
                                                                                        <th>No Invoice</th>
                                                                                        <th>ETD</th>
                                                                                        <th>Pengirim</th>
                                                                                        <th>Penerima</th>
                                                                                        <th>Tagihan</th>
                                                                                        <th>Tanda Terima</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>${rows}</tbody>
                                                                            </table>
                                                                            <script>window.print();<\/script>
                                                                        </body>
                                                                        </html>
                                                                    `);
            printWindow.document.close();
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
            var judul = $('#filterJudulPrint').val() || '';
            var search = $('#invoiceTable').DataTable().search() || '';

            var url = '{{ route('admin.invoice.export') }}?daterange=' + encodeURIComponent(daterange) +
                '&status=' + encodeURIComponent(status) +
                '&asal_id=' + encodeURIComponent(asal) +
                '&tujuan_id=' + encodeURIComponent(tujuan) +
                '&pengirim_id=' + encodeURIComponent(pengirim) +
                '&judul_print_id=' + encodeURIComponent(judul) +
                '&search=' + encodeURIComponent(search);

            window.location.href = url;
        }
    </script>
@endpush