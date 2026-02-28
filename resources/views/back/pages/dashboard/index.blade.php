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

    <div class="row">
        <!-- [Total Invoice] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                <i class="feather-file"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $total_invoice }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Invoice</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Total Invoice] end -->

        <!-- [Total Pendapatan] start -->
        @if(auth()->user()->hasRole('admin') || auth()->user()->can('view_total_pendapatan.dashboard'))
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-soft-success text-success">
                                    <i class="feather-dollar-sign"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">Rp <span
                                            class="counter">{{ number_format($total_pendapatan, 0, ',', '.') }}</span></div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Pendapatan</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- [Total Pendapatan] end -->

        <!-- [Belum Ditagih] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-danger text-danger">
                                <i class="feather-clock"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $belum_ditagih }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Belum Ditagih</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Belum Ditagih] end -->

        <!-- [Sudah Ditagih] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-info text-info">
                                <i class="feather-check-circle"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $sudah_ditagih }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Sudah Ditagih</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Sudah Ditagih] end -->

        <!-- [Lunas] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-success text-success">
                                <i class="feather-check-circle"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $lunas }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Lunas</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Lunas] end -->

        <!-- [Belum Lunas] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                <i class="feather-clock"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $belum_lunas }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Belum Lunas</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Belum Lunas] end -->

        <!-- [PKP] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                <i class="feather-file-text"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $pkp }}</span>
                                </div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">PKP</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [PKP] end -->

        <!-- [Non PKP] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-soft-secondary text-secondary">
                                <i class="feather-file-text"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $non_pkp }}</span></div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Non PKP</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [Non PKP] end -->
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