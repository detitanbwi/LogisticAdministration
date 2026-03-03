@extends('back.layouts.app')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4" id="filterForm">
        <div class="row align-items-center justify-content-end">
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="feather-calendar"></i></span>
                    <input type="text" class="form-control text-center" name="daterange" id="dashboardDaterange"
                        value="{{ $daterange }}">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-icon" title="Reset"><i
                            class="feather-refresh-ccw"></i></a>
                </div>
            </div>
        </div>
    </form>

    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0" style="font-size: 13px;">
                    <thead>
                        <tr style="background-color: #f8f9fc;" class="border-bottom">
                            <th class="text-muted fw-semibold py-2 px-4" style="width:50%; font-size:11px; letter-spacing:0.5px;">INVOICE & STATUS</th>
                            <th class="text-muted fw-semibold py-2 px-4 border-start" style="width:50%; font-size:11px; letter-spacing:0.5px;">TAGIHAN & PEMBAYARAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-bottom">
                            <td class="px-4 py-2 border-end">
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-medium">Total Invoice</span>
                                    <span class="fw-bold text-primary">{{ $total_invoice }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-medium">Sudah Ditagih</span>
                                    <span class="fw-bold text-info">{{ $sudah_ditagih }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-4 py-2 border-end">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">PKP</span>
                                    <span class="fw-semibold">{{ $pkp }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Belum Ditagih</span>
                                    <span class="fw-semibold text-danger">{{ $belum_ditagih }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-4 py-2 border-end">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Non PKP</span>
                                    <span class="fw-semibold">{{ $non_pkp }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-medium">Lunas</span>
                                    <span class="fw-bold text-success">{{ $lunas }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="px-4 py-2 border-end">
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('view.finance') || auth()->user()->can('view.transaksi'))
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-medium">Total Pendapatan</span>
                                    <span class="fw-bold text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Belum Lunas</span>
                                    <span class="fw-semibold text-warning">{{ $belum_lunas }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-end"></td>
                            <td class="px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark fw-medium">Total Belum Lunas</span>
                                    <span class="fw-bold text-danger">Rp {{ number_format($total_belum_lunas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Invoice Terbaru</h5>
                    <a href="{{ route('admin.invoice.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
                <div class="card-body custom-card-action p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="border-b">
                                    <th>No Invoice</th>
                                    <th>Pengirim</th>
                                    <th>Tanggal</th>
                                    <th>Total Tagihan</th>
                                    <th>Status Tagihan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_invoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.invoice.edit', $invoice->id) }}"
                                                class="fw-bold">{{ $invoice->no_invoice }}</a>
                                        </td>
                                        <td>
                                            {{ $invoice->pengirim->nama ?? '-' }}
                                        </td>
                                        <td>{{ $invoice->created_at->translatedFormat('d F Y') }}</td>
                                        <td>Rp {{ number_format($invoice->finance->total_tagihan ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $status = $invoice->finance->status_tagihan ?? 'Belum';
                                                $color = $status == 'Sudah ditagih' ? 'success' : 'warning';
                                            @endphp
                                            <span class="badge bg-soft-{{ $color }} text-{{ $color }}">{{ $status }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.invoice.print', $invoice->id) }}" target="_blank"
                                                class="avatar-text avatar-sm" title="Print Invoice">
                                                <i class="feather-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-4">Belum ada data invoice terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            if ($('#dashboardDaterange').length) {
                $('#dashboardDaterange').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'MM/DD/YYYY'
                    }
                });

                $('#dashboardDaterange').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                    $('#filterForm').submit();
                });

                $('#dashboardDaterange').on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                    window.location.href = "{{ route('admin.dashboard') }}";
                });
            }
        });
    </script>
@endpush