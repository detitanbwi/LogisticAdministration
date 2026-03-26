@extends('back.layouts.app')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@push('styles')
    <style>
        /* ===== Dashboard Stats Cards ===== */
        .dash-stat-card {
            border: none;
            border-radius: 10px;
            color: #fff;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 58px;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            position: relative;
            overflow: hidden;
        }

        .dash-stat-card::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        .dash-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .dash-stat-card .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            opacity: 0.95;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dash-stat-card .stat-label i {
            font-size: 16px;
            opacity: 0.85;
        }

        .dash-stat-card .stat-value {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Color Palette - Modern & Bold */
        .bg-dash-navy {
            background: linear-gradient(135deg, #2c3e6b, #3b4f80);
        }

        .bg-dash-teal {
            background: linear-gradient(135deg, #1a9e8f, #20b2a0);
        }

        .bg-dash-rose {
            background: linear-gradient(135deg, #c0392b, #d94040);
        }

        .bg-dash-amber {
            background: linear-gradient(135deg, #e8a317, #f0b429);
        }

        .bg-dash-purple {
            background: linear-gradient(135deg, #6c4fa0, #7e5bb5);
        }

        .bg-dash-slate {
            background: linear-gradient(135deg, #34495e, #415b76);
        }

        .bg-dash-emerald {
            background: linear-gradient(135deg, #169b6b, #1db980);
        }

        .bg-dash-crimson {
            background: linear-gradient(135deg, #b03060, #c94070);
        }

        /* Total Pendapatan - Full Width Accent */
        .dash-total-card {
            border: none;
            border-radius: 10px;
            color: #fff;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            position: relative;
            overflow: hidden;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .dash-total-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        .dash-total-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            pointer-events: none;
        }

        .dash-total-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }

        .dash-total-card .total-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dash-total-card .total-label i {
            font-size: 20px;
        }

        .dash-total-card .total-value {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Date filter styling */
        .dash-date-filter {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .dash-date-filter .input-group {
            max-width: 320px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .dash-date-filter .input-group-text {
            background: #f0f3f8;
            border: 1px solid #dde2ea;
            border-right: none;
            color: #5a6a85;
        }

        .dash-date-filter .form-control {
            border: 1px solid #dde2ea;
            border-left: none;
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            text-align: center;
        }

        .dash-date-filter .btn-reset {
            border: 1px solid #dde2ea;
            border-left: none;
            background: #f0f3f8;
            color: #5a6a85;
            transition: background 0.15s;
        }

        .dash-date-filter .btn-reset:hover {
            background: #e2e6ee;
            color: #2d3748;
        }

        /* Stats grid */
        .dash-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media (max-width: 576px) {
            .dash-grid {
                grid-template-columns: 1fr;
            }

            .dash-stat-card .stat-value {
                font-size: 18px;
            }

            .dash-total-card .total-value {
                font-size: 20px;
            }
        }

        /* Recent Invoice Table improvements */
        .recent-invoice-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .recent-invoice-card .card-header {
            background: #f8f9fc;
            border-bottom: 1px solid #edf0f5;
            padding: 14px 20px;
        }

        .recent-invoice-card .card-header h5 {
            font-size: 14px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    {{-- Date Filter --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
        <div class="dash-date-filter">
            <div class="input-group">
                <span class="input-group-text"><i class="feather-calendar"></i></span>
                <input type="text" class="form-control" name="daterange" id="dashboardDaterange" value="{{ $daterange }}"
                    readonly>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-reset" title="Reset">
                    <i class="feather-refresh-ccw"></i>
                </a>
            </div>
        </div>
    </form>

    <div class="dash-grid mb-3">
        {{-- 1. Total Invoice --}}
        <div class="dash-stat-card bg-dash-navy">
            <span class="stat-label"><i class="feather-file-text"></i> Total Invoice</span>
            <span class="stat-value">{{ $total_invoice }}</span>
        </div>
        {{-- 2. PKP --}}
        <div class="dash-stat-card bg-dash-purple">
            <span class="stat-label"><i class="feather-shield"></i> PKP</span>
            <span class="stat-value">{{ $pkp }}</span>
        </div>
        {{-- 3. Non PKP --}}
        <div class="dash-stat-card bg-dash-slate">
            <span class="stat-label"><i class="feather-tag"></i> Non PKP</span>
            <span class="stat-value">{{ $non_pkp }}</span>
        </div>
        {{-- 4. Sudah Ditagih --}}
        <div class="dash-stat-card bg-dash-teal">
            <span class="stat-label"><i class="feather-check-circle"></i> Sudah Ditagih</span>
            <span class="stat-value">{{ $sudah_ditagih }}</span>
        </div>
        {{-- 5. Belum Ditagih --}}
        <div class="dash-stat-card bg-dash-amber">
            <span class="stat-label"><i class="feather-alert-circle"></i> Belum Ditagih</span>
            <span class="stat-value">{{ $belum_ditagih }}</span>
        </div>
        {{-- 6. Lunas --}}
        <div class="dash-stat-card bg-dash-emerald">
            <span class="stat-label"><i class="feather-thumbs-up"></i> Lunas</span>
            <span class="stat-value">{{ $lunas }}</span>
        </div>
        {{-- 7. Belum Lunas --}}
        <div class="dash-stat-card bg-dash-rose">
            <span class="stat-label"><i class="feather-x-circle"></i> Belum Lunas</span>
            <span class="stat-value">{{ $belum_lunas }}</span>
        </div>
        {{-- 8. Total Belum Lunas --}}
        <div class="dash-stat-card bg-dash-crimson">
            <span class="stat-label"><i class="feather-credit-card"></i> Total Belum Lunas</span>
            <span class="stat-value">Rp {{ number_format($total_belum_lunas, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- 9. Total Pendapatan --}}
    @if(auth()->user()->hasRole('admin') || auth()->user()->can('view.finance') || auth()->user()->can('view.transaksi'))
        <div class="dash-total-card mb-4">
            <span class="total-label"><i class="feather-trending-up"></i> Total Pendapatan</span>
            <span class="total-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
        </div>
    @endif

    {{-- Recent Invoices --}}
    <div class="row">
        <div class="col-12">
            <div class="card recent-invoice-card stretch stretch-full">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0"><i class="feather-layers me-2"></i>Invoice Terbaru</h5>
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