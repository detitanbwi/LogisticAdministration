<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rincian Volume - {{ $invoice->no_invoice }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .bordered {
            border: 1px solid #000;
        }

        .collapse {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 8px 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .w-100 {
            width: 100%;
        }

        @page {
            size: portrait;
            margin: 1.25cm;
        }

        @media print {
            body {
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
                visibility: hidden !important;
            }
        }

        /* Mockup specific styles */
        .header-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-card {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-label {
            font-size: 9pt;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 12pt;
            font-weight: bold;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table-custom th {
            background-color: #1a3a5f; /* Deep blue from mockup */
            color: white;
            text-transform: uppercase;
            font-size: 9pt;
            border: 1px solid #dee2e6;
            padding: 4px 6px;
        }

        .table-custom td {
            border: 1px solid #dee2e6;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .total-row {
            background-color: #1a3a5f;
            color: white;
            font-weight: bold;
        }

        .total-label {
            background-color: #1a3a5f;
            color: white;
            text-align: center;
            padding: 6px;
            font-size: 10pt;
            text-transform: uppercase;
        }

        .total-value {
            background-color: #e7f1ff;
            color: #1a3a5f;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            padding: 6px;
            border: 1px solid #dee2e6;
        }

        .catatan-box {
            background-color: #fffdf0; /* Light yellow */
            border: 1px solid #ffeeba;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }

        .formula-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 10pt;
            line-height: 1.6;
        }

        .badge-unit {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #e7f1ff;
            color: #0d6efd;
            font-size: 9pt;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">
    <div style="max-width: 950px; margin: 0 auto; background: #fff; padding: 10px;">
        <!-- Standard Header (Kop) -->
        <table class="w-100 collapse" style="border-bottom: 1px solid #000; margin-bottom: 15px;">
            <tr>
                <td style="width: 20%; vertical-align: middle; padding: 5px;">
                    <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo"
                        style="max-height: 80px; max-width: 120px; object-fit: contain;">
                </td>
                <td style="width: 80%; vertical-align: top; text-align: right; padding: 5px;">
                    <h1 style="margin: 0 0 5px 0; font-family: 'Arial', sans-serif; font-size: 20pt; font-weight: bold;">
                        PT. SINAR <span style="color: red;">CEMARA</span> JAYA</h1>
                    <div style="font-size: 9pt; font-weight: bold; line-height: 1.3;">
                        JL. Swasembada Timur XIII No.32 C, Kebon Bawang, Tanjung Priok, Jakarta Utara<br>
                        Email: sinarcemarajaya@gmail.com | <a href="http://www.sinarcemarajaya.com"
                            style="color: blue; text-decoration: underline;">www.sinarcemarajaya.com</a>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Page Title -->
        <div style="margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1a3a5f; font-size: 18pt;">DATA VOLUME BARANG</h2>
            <p style="margin: 0; color: #6c757d; font-size: 10pt; text-transform: uppercase;">Rincian Perhitungan Volume
            </p>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-card">
                <div style="color: #1a3a5f;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></div>
                <div>
                    <div class="info-label">No Invoice</div>
                    <div class="info-value">{{ $invoice->no_invoice }}</div>
                </div>
            </div>
            <div class="info-card">
                <div style="color: #1a3a5f;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></div>
                <div>
                    <div class="info-label">Tgl Masuk</div>
                    <div class="info-value">{{ $invoice->tgl_masuk ? $invoice->tgl_masuk->format('d-M-Y') : ($invoice->created_at ? $invoice->created_at->format('d-M-Y') : '-') }}</div>
                </div>
            </div>
            <div class="info-card">
                <div style="color: #1a3a5f;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div>
                <div>
                    <div class="info-label">Pengirim</div>
                    <div class="info-value">{{ $invoice->pengirim ? $invoice->pengirim->nama : '-' }}</div>
                </div>
            </div>
            <div class="info-card">
                <div style="color: #1a3a5f;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></div>
                <div>
                    <div class="info-label">Penerima</div>
                    <div class="info-value">{{ $invoice->penerima ? $invoice->penerima->nama : '-' }}</div>
                </div>
            </div>
        </div>

        @foreach($invoice->items as $item)
            @php 
                $unit = $item->satuan;
            @endphp
            <div style="margin-top: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 style="margin: 0; color: #1a3a5f; border-left: 4px solid #1a3a5f; padding-left: 10px;">{{ strtoupper($item->jenis_barang) }}</h3>
                    <div class="badge-unit">{{ strtoupper($unit) }}</div>
                </div>
                
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th>P (CM)</th>
                            <th>L (CM)</th>
                            <th>T (CM)</th>
                            <th>KOLI</th>
                            <th>{{ $unit == 'Kg' ? 'BERAT (KG)' : ($unit == 'Unit' ? 'JUMLAH' : 'VOLUME (M3)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($item->details && $item->details->count() > 0)
                            @foreach($item->details as $dIdx => $detail)
                                <tr>
                                    <td class="text-center">{{ $dIdx + 1 }}</td>
                                    <td class="text-center">{{ (float)$detail->p ?: '-' }}</td>
                                    <td class="text-center">{{ (float)$detail->l ?: '-' }}</td>
                                    <td class="text-center">{{ (float)$detail->t ?: '-' }}</td>
                                    <td class="text-center font-bold">{{ $detail->koli }}</td>
                                    <td class="text-center font-bold" style="color: #0d6efd;">
                                        {{ number_format($detail->jumlah, 3, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">{{ (float)$item->p ?: '-' }}</td>
                                <td class="text-center">{{ (float)$item->l ?: '-' }}</td>
                                <td class="text-center">{{ (float)$item->t ?: '-' }}</td>
                                <td class="text-center font-bold">{{ $item->koli }}</td>
                                <td class="text-center font-bold" style="color: #0d6efd;">
                                    {{ number_format($item->jumlah, 3, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Summary Row -->
                <table class="w-100 collapse">
                    <tr>
                        <td class="total-label" style="width: 25%;">TOTAL KOLI</td>
                        <td class="total-value" style="width: 25%;">{{ number_format($item->koli, 0, ',', '.') }} <span style="font-size: 10pt;">KOLI</span></td>
                        <td class="total-label" style="width: 25%;">TOTAL {{ strtoupper($unit) }}</td>
                        <td class="total-value" style="width: 25%;">{{ number_format($item->jumlah, 3, ',', '.') }} <span style="font-size: 10pt;">{{ strtoupper($unit) }}</span></td>
                    </tr>
                </table>
            </div>
        @endforeach

        <!-- Catatan Section -->
        <div class="catatan-box">
            <div style="background-color: #ffd700; color: #1a3a5f; padding: 10px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </div>
            <div>
                <h4 style="margin: 0 0 10px 0; color: #856404;">Catatan :</h4>
                <ul class="formula-list">
                    <li>1. Perhitungan volume (m³): P x L x T &divide; 1.000.000 x Koli</li>
                    <li>2. Perhitungan berat (kg): P x L x T &divide; 4.000 x Koli</li>
                    <li>3. Satuan dimensi: centimeter (cm)</li>
                </ul>
            </div>
        </div>

        <!-- Print Buttons -->
        <div class="text-center no-print" style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
            <button onclick="window.print()"
                style="padding: 12px 24px; font-size: 14px; cursor: pointer; background: #0d6efd; border: none; color: white; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                CETAK HALAMAN
            </button>
            <button onclick="window.close()"
                style="padding: 12px 24px; font-size: 14px; cursor: pointer; background: #6c757d; border: none; color: white; border-radius: 6px; font-weight: bold;">
                TUTUP
            </button>
        </div>
    </div>
</body>

</html>
