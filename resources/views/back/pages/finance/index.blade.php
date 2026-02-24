@extends('back.layouts.app')

@section('title', 'Finance')
@section('page_title', 'Finance')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.finance.index') }}">Finance</a></li>
@endsection

@section('content')
    <div class="d-flex align-items-center mb-4 gap-2 flex-wrap">
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
        <button class="btn btn-light"
            onclick="$('.dt-filter').val(''); $('#filterStatus').val('').trigger('change'); $('#financeTable').DataTable().ajax.reload()">Reset</button>
    </div>

    <x-back.datatable id="financeTable" :ajax="route('admin.finance.index')" :header="['No', 'No Invoice', 'Total Tagihan', 'Status Tagihan', 'Tgl Transfer', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'no_invoice',
        'total_tagihan',
        'status_tagihan',
        'tgl_transfer',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(function() {
            // Native select change handler
            $('#filterStatus').on('change', function() {
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

                $('#filterDaterange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                    $('#financeTable').DataTable().ajax.reload();
                });

                $('#filterDaterange').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    $('#financeTable').DataTable().ajax.reload();
                });
            }
        });
    </script>
@endpush
