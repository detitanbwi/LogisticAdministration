@extends('back.layouts.app')

@section('title', 'Invoice')
@section('page_title', 'Invoice')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">Invoice</a></li>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="input-group" style="width: 280px;">
                <span class="input-group-text"><i class="feather-calendar"></i></span>
                <input type="text" class="form-control text-center dt-filter" name="daterange" id="filterDaterange"
                    placeholder="Pilih Tanggal">
            </div>
            <select class="form-select dt-filter" id="filterStatus" name="status" style="width: 180px;">
                <option value="">Semua Status</option>
                <option value="Belum">Belum</option>
                <option value="Bayar">Bayar</option>
                <option value="Tahan">Tahan</option>
                <option value="Cancel">Cancel</option>
                <option value="Serahkan">Serahkan</option>
            </select>
            <select class="form-select dt-filter" id="filterAsal" name="asal_id" style="width: 180px;">
                <option value="">Semua Asal</option>
                @foreach ($tujuans as $t)
                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                @endforeach
            </select>
            <select class="form-select dt-filter" id="filterTujuan" name="tujuan_id" style="width: 180px;">
                <option value="">Semua Tujuan</option>
                @foreach ($tujuans as $t)
                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                @endforeach
            </select>
            <button class="btn btn-light"
                onclick="$('.dt-filter').val(''); $('#invoiceTable').DataTable().ajax.reload()">Reset</button>
            <button class="btn btn-outline-primary" id="btnPrint" onclick="printTable()">
                <i class="feather-printer me-1"></i> Print
            </button>
        </div>
        <div>
            @can('create.invoice')
                <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Buat Invoice</span>
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
            'Catatan Muntahan',
            'Aksi',
        ]" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'no_invoice',
            'etd',
            'asal' => ['searchable' => false, 'orderable' => false],
            'tujuan' => ['searchable' => false, 'orderable' => false],
            'pengirim',
            'penerima',
            'total_tagihan' => ['searchable' => false, 'orderable' => false],
            'catatan_muntahan' => ['searchable' => false, 'orderable' => false],
            'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
        ]" />
@endsection

@push('scripts')
    <script>
        $(function () {
            // Filter change handlers
            $('#filterStatus, #filterAsal, #filterTujuan').on('change', function () {
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

        function printTable() {
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
    </script>
@endpush