@extends('back.layouts.app')

@section('title', 'Finance')
@section('page_title', 'Finance')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.finance.index') }}">Finance</a></li>
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
                <option value="Sudah ditagih">Sudah ditagih</option>
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
                onclick="$('.dt-filter').val(''); $('#filterStatus').val('').trigger('change'); $('#financeTable').DataTable().ajax.reload()">Reset</button>
            <button class="btn btn-outline-primary" id="btnPrint" onclick="printTable()">
                <i class="feather-printer me-1"></i> Print
            </button>
        </div>
    </div>

    <x-back.datatable id="financeTable" :ajax="route('admin.finance.index')" :header="['No', 'No Invoice', 'Pengirim', 'Penerima', 'Total Tagihan', 'Status Tagihan', 'Tanggal Tagih', 'Masa Tunggakan', 'Tgl Transfer', 'Aksi']" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'no_invoice',
            'pengirim',
            'penerima',
            'total_tagihan',
            'status_tagihan',
            'tanggal_tagih',
            'masa_tunggakan' => ['searchable' => false, 'orderable' => false],
            'tgl_transfer',
            'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
        ]" />
@endsection

@push('scripts')
    <script>
        $(function () {
            // Native select change handler
            $('#filterStatus, #filterAsal, #filterTujuan').on('change', function () {
                $('#financeTable').DataTable().ajax.reload();
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
                    $('#financeTable').DataTable().ajax.reload();
                });

                $('#filterDaterange').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                    $('#financeTable').DataTable().ajax.reload();
                });
            }
        });

        function printTable() {
            var table = $('#financeTable').DataTable();
            var printWindow = window.open('', '_blank');
            var rows = '';

            table.rows({
                search: 'applied'
            }).every(function () {
                var data = this.data();
                var statusMasa = data.masa_tunggakan;
                // remove HTML from masa_tunggakan/status
                var tempDiv = document.createElement('div');

                tempDiv.innerHTML = data.status_tagihan;
                var statusText = tempDiv.textContent || tempDiv.innerText || '';

                tempDiv.innerHTML = data.masa_tunggakan;
                var masaText = tempDiv.textContent || tempDiv.innerText || '';

                rows += '<tr>' +
                    '<td>' + data.DT_RowIndex + '</td>' +
                    '<td>' + data.no_invoice + '</td>' +
                    '<td>' + data.pengirim + '</td>' +
                    '<td>' + data.penerima + '</td>' +
                    '<td>' + data.total_tagihan + '</td>' +
                    '<td>' + statusText + '</td>' +
                    '<td>' + (data.tanggal_tagih ? data.tanggal_tagih : '-') + '</td>' +
                    '<td>' + masaText + '</td>' +
                    '</tr>';
            });

            var filterInfo = '';
            var asal = $('#filterAsal option:selected').text();
            var tujuan = $('#filterTujuan option:selected').text();
            if ($('#filterAsal').val()) filterInfo += '<p><strong>Asal:</strong> ' + asal + '</p>';
            if ($('#filterTujuan').val()) filterInfo += '<p><strong>Tujuan:</strong> ' + tujuan + '</p>';
            if ($('#filterDaterange').val()) filterInfo += '<p><strong>Periode:</strong> ' + $('#filterDaterange').val() + '</p>';

            printWindow.document.write(`
                    <html>
                    <head>
                        <title>Rekapitulasi Finance</title>
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
                        <h2>Rekapitulasi Finance</h2>
                        <h4 style="text-align:center; margin-top:0;">PT. SINAR CEMARA JAYA</h4>
                        <div class="filter-info">${filterInfo}</div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Invoice</th>
                                    <th>Pengirim</th>
                                    <th>Penerima</th>
                                    <th>Total Tagihan</th>
                                    <th>Status Tagihan</th>
                                    <th>Tanggal Tagih</th>
                                    <th>Masa Tunggakan</th>
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
    </script>
@endpush