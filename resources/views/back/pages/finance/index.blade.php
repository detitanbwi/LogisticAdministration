@extends('back.layouts.app')

@section('title', 'Finance')
@section('page_title', 'Finance')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.finance.index') }}">Finance</a></li>
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
    </style>
    <div class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" class="form-select dt-filter" name="daterange" id="filterDaterange"
                placeholder="Pilih Tanggal" style="cursor: pointer; background-color: #fff; height: 38px;" readonly>
        </div>
        <div class="col-md-6">
            <select class="form-select dt-filter" id="filterStatus" name="status" style="width: 100%;">
                <option value="">Semua Status</option>
                <option value="Belum">Belum Ditagih</option>
                <option value="Sudah ditagih">Sudah Ditagih</option>
                <option value="Belum Lunas">Belum Lunas</option>
                <option value="Lunas">Lunas</option>
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
                    onclick="$('.dt-filter').val('').trigger('change'); $('#financeTable').DataTable().ajax.reload()">
                    <i class="feather-refresh-ccw me-1"></i> RESET
                </button>
                <button class="btn btn-outline-primary" id="btnPrint" onclick="printTable()">
                    <i class="feather-printer me-1"></i> PRINT
                </button>
                <button class="btn btn-outline-success" id="btnExport" onclick="exportExcel()">
                    <i class="feather-download me-1"></i> EXCEL
                </button>
            </div>
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

            // Native select change handler
            $('#filterStatus, #filterAsal, #filterTujuan, #filterPengirim, #filterPenerima').on('change', function () {
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

        window.printTable = function () {
            var daterange = $('#filterDaterange').val();
            if (!daterange) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Silakan pilih range tanggal terlebih dahulu untuk mencetak rekapitulasi.',
                    icon: 'warning'
                });
                return;
            }
            var table = $('#financeTable').DataTable();
            var printWindow = window.open('', '_blank');
            var totalGrandTagihan = 0;
            var rows = '';
            table.rows({
                search: 'applied'
            }).every(function () {
                var data = this.data();
                
                // Accumulate total tagihan for Grand Total
                if(data.total_tagihan) {
                    var numericTotal = data.total_tagihan.replace(/[^0-9]/g, '');
                    totalGrandTagihan += parseInt(numericTotal) || 0;
                }

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

            var formattedGrandTotal = 'Rp ' + totalGrandTagihan.toLocaleString('id-ID');

            var filterInfo = '';
            var asal = $('#filterAsal option:selected').text();
            var tujuan = $('#filterTujuan option:selected').text();
            if ($('#filterAsal').val()) filterInfo += '<p><strong>Asal:</strong> ' + asal + '</p>';
            if ($('#filterTujuan').val()) filterInfo += '<p><strong>Tujuan:</strong> ' + tujuan + '</p>';
            if ($('#filterDaterange').val()) filterInfo += '<p><strong>Periode:</strong> ' + $('#filterDaterange').val() + '</p>';

            var title = $('#filterJudulPrint option:selected').val() ? $('#filterJudulPrint option:selected').text() : 'LAPORAN PEMBAYARAN REKAPITULASI FINANCE';
            printWindow.document.write(`
                                                                                <html>
                                                                                <head>
                                                                                    <title>${title}</title>
                                                                                    <style>
                                                                                        body { font-family: Arial, sans-serif; font-size: 11pt; margin: 1.25cm; }
                                                                                        h2 { text-align: center; margin-bottom: 25px; }
                                                                                        .filter-info { margin-bottom: 15px; }
                                                                                        .filter-info p { margin: 2px 0; font-size: 10pt; }
                                                                                        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                                                                                        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; font-size: 10pt; }
                                                                                        th { background-color: #8B4513 !important; color: white !important; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                                                                                        @media print { 
                                                                                            body { margin: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; } 
                                                                                            th { background-color: #8B4513 !important; color: white !important; }
                                                                                            tfoot tr { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
                                                                                        }
                                                                                    </style>
                                                                                </head>
                                                                                <body>
                                                                                    <h2>${title}</h2>
                                                                                    <div class="filter-info">${filterInfo}</div>
                                                                                    <table>
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">No</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">No Invoice</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Pengirim</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Penerima</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Total Tagihan</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Status Tagihan</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Tanggal Tagih</th>
                                                                                                <th style="background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; font-weight: bold; text-align: center;">Masa Tunggakan</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>${rows}</tbody>
                                                                                        <tfoot>
                                                                                            <tr style="font-weight: bold; background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                                                                                                <td colspan="4" style="text-align: right;">GRAND TOTAL</td>
                                                                                                <td>${formattedGrandTotal}</td>
                                                                                                <td colspan="3"></td>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                    <script>window.print();<\/script>
                                                                                </body>
                                                                                </html>
                                                                            `);
            printWindow.document.close();
        }

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
            var daterange = $('#filterDaterange').val();
            if (!daterange) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Silakan pilih range tanggal terlebih dahulu untuk eksport excel.',
                    icon: 'warning'
                });
                return;
            }

            var filters = {
                type: 'finance',
                daterange: daterange,
                status: $('#filterStatus').val() || '',
                asal_id: $('#filterAsal').val() || '',
                tujuan_id: $('#filterTujuan').val() || '',
                pengirim_id: $('#filterPengirim').val() || '',
                penerima_id: $('#filterPenerima').val() || '',
                judul_print_id: $('#filterJudulPrint').val() || '',
                search: $('#financeTable').DataTable().search() || ''
            };

            startProgressiveExport(filters);
        }

        function startProgressiveExport(filters) {
            var modal = new bootstrap.Modal(document.getElementById('exportProgressModal'));
            var progressBar = $('#exportProgressBar');
            var progressText = $('#exportProgressText');
            var progressDetail = $('#exportProgressDetail');
            var taskId = '';
            var isCancelled = false;

            modal.show();
            progressBar.css('width', '0%').html('0%');
            progressText.html('Menyiapkan data...');
            progressDetail.html('Menghitung total records...');

            // Init
            $.post('{{ route("admin.export.init") }}', filters)
                .done(function (res) {
                    taskId = res.task_id;
                    var total = res.total;
                    progressText.html('Memproses ' + total + ' records...');
                    
                    processNextChunk(taskId, 0, total);
                })
                .fail(function (xhr) {
                    modal.hide();
                    var msg = xhr.responseJSON?.error || 'Gagal memulai eksport.';
                    Swal.fire('Error', msg, 'error');
                });

            function processNextChunk(id, processed, total) {
                if (isCancelled) return;

                $.post('{{ route("admin.export.process") }}', { task_id: id })
                    .done(function (res) {
                        if (res.cancelled) {
                            modal.hide();
                            Swal.fire('Dibatalkan', 'Proses eksport telah dibatalkan.', 'info');
                            return;
                        }

                        var current = res.processed;
                        var percent = Math.round((current / total) * 100);
                        progressBar.css('width', percent + '%').html(percent + '%');
                        progressDetail.html('Diproses: ' + current + ' / ' + total);

                        if (current < total) {
                            processNextChunk(id, current, total);
                        } else {
                            // Done
                            progressText.html('Menyusun file Excel...');
                            progressDetail.html('Hampir selesai, file akan otomatis terunduh...');
                            
                            // Trigger download
                            window.location.href = '{{ route("admin.export.download") }}?task_id=' + id;
                            
                            // Close modal after a delay to give browser time to start download
                            setTimeout(function() {
                                modal.hide();
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Eksport selesai dan file sedang diunduh.',
                                    icon: 'success',
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }, 5000);
                        }
                    })
                    .fail(function () {
                        modal.hide();
                        Swal.fire('Error', 'Terjadi kesalahan saat memproses data.', 'error');
                    });
            }

            $('#btnCancelExport').off('click').on('click', function () {
                isCancelled = true;
                $.post('{{ route("admin.export.cancel") }}', { task_id: taskId });
                modal.hide();
            });
        }
    </script>
@endpush