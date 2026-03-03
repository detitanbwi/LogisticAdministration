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
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr class="border-bottom" style="background-color: #f8f9fc;">
                            <th class="text-muted fw-semibold py-3 px-4" style="width:33.33%; font-size:12px; letter-spacing:0.5px;">INVOICE</th>
                            <th class="text-muted fw-semibold py-3 px-4 border-start" style="width:33.33%; font-size:12px; letter-spacing:0.5px;">PENAGIHAN</th>
                            <th class="text-muted fw-semibold py-3 px-4 border-start" style="width:33.33%; font-size:12px; letter-spacing:0.5px;">PEMBAYARAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- Kolom 1: Invoice --}}
                            <td class="px-4 py-3 align-top border-end">
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-soft-primary text-primary" style="width:28px;height:28px;font-size:13px;">
                                            <i class="feather-file"></i>
                                        </span>
                                        <span class="fw-medium text-dark">Total Invoice</span>
                                    </div>
                                    <span class="fs-5 fw-bold text-primary">{{ $total_invoice }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2 border-top">
                                    <span class="text-muted small">PKP</span>
                                    <span class="fw-semibold">{{ $pkp }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2 border-top">
                                    <span class="text-muted small">Non PKP</span>
                                    <span class="fw-semibold">{{ $non_pkp }}</span>
                                </div>
                            </td>

                            {{-- Kolom 2: Penagihan --}}
                            <td class="px-4 py-3 align-top border-end">
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-soft-info text-info" style="width:28px;height:28px;font-size:13px;">
                                            <i class="feather-check-circle"></i>
                                        </span>
                                        <span class="fw-medium text-dark">Sudah Ditagih</span>
                                    </div>
                                    <span class="fs-5 fw-bold text-info">{{ $sudah_ditagih }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2 border-top">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-danger small"><i class="feather-clock" style="font-size:12px;"></i></span>
                                        <span class="text-muted small">Belum Ditagih</span>
                                    </div>
                                    <span class="fw-semibold text-danger">{{ $belum_ditagih }}</span>
                                </div>
                            </td>

                            {{-- Kolom 3: Pembayaran --}}
                            <td class="px-4 py-3 align-top">
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-soft-success text-success" style="width:28px;height:28px;font-size:13px;">
                                            <i class="feather-check-circle"></i>
                                        </span>
                                        <span class="fw-medium text-dark">Lunas</span>
                                    </div>
                                    <span class="fs-5 fw-bold text-success">{{ $lunas }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2 border-top">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-warning small"><i class="feather-clock" style="font-size:12px;"></i></span>
                                        <span class="text-muted small">Belum Lunas</span>
                                    </div>
                                    <span class="fw-semibold text-warning">{{ $belum_lunas }}</span>
                                </div>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('view.finance') || auth()->user()->can('view.transaksi'))
                                <div class="d-flex align-items-center justify-content-between py-2 border-top">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-success small"><i class="feather-dollar-sign" style="font-size:12px;"></i></span>
                                        <span class="text-muted small">Pendapatan</span>
                                    </div>
                                    <span class="fw-bold text-success" title="Rp {{ number_format($total_pendapatan, 0, ',', '.') }}">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
                                </div>
                                @endif
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