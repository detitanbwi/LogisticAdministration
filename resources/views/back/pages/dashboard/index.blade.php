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

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 pb-0 pt-4">
            <h6 class="card-title mb-0">Ringkasan Invoice & Keuangan</h6>
        </div>
        <div class="card-body">
            <div class="row gx-4 gy-3">
                <!-- Kolom 1 (Statistik Invoice) -->
                <div class="col-md-4">
                    <div class="h-100 p-3 rounded bg-light border border-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-dashed">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-file text-primary fs-5"></i>
                                <span class="fw-semibold text-dark">Total Invoice</span>
                            </div>
                            <span class="fs-4 fw-bold text-primary">{{ $total_invoice }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-file-text text-muted fs-5"></i>
                                <span class="text-muted">Status PKP</span>
                            </div>
                            <span class="fs-6 fw-bold text-dark">{{ $pkp }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-file-minus text-muted fs-5"></i>
                                <span class="text-muted">Status Non PKP</span>
                            </div>
                            <span class="fs-6 fw-bold text-dark">{{ $non_pkp }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2 (Tagihan) -->
                <div class="col-md-4">
                    <div class="h-100 p-3 rounded bg-light border border-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-dashed">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-check-circle text-info fs-5"></i>
                                <span class="fw-semibold text-dark">Sudah Ditagih</span>
                            </div>
                            <span class="fs-4 fw-bold text-info">{{ $sudah_ditagih }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-clock text-danger fs-5"></i>
                                <span class="text-muted">Belum Ditagih</span>
                            </div>
                            <span class="fs-6 fw-bold text-danger">{{ $belum_ditagih }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3 (Pembayaran) -->
                <div class="col-md-4">
                    <div class="h-100 p-3 rounded bg-light border border-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-dashed">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-check-circle text-success fs-5"></i>
                                <span class="fw-semibold text-dark">Lunas</span>
                            </div>
                            <span class="fs-4 fw-bold text-success">{{ $lunas }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-clock text-warning fs-5"></i>
                                <span class="text-muted">Belum Lunas</span>
                            </div>
                            <span class="fs-6 fw-bold text-warning">{{ $belum_lunas }}</span>
                        </div>

                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('view.finance') || auth()->user()->can('view.transaksi'))
                        <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top border-dashed">
                            <div class="d-flex align-items-center gap-2">
                                <i class="feather-dollar-sign text-success fs-5"></i>
                                <span class="fw-semibold text-dark">Pendapatan</span>
                            </div>
                            <span class="fs-5 fw-bold text-success text-truncate" title="Rp {{ number_format($total_pendapatan, 0, ',', '.') }}">
                                Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
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