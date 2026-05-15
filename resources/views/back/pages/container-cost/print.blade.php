<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>CONTAINER COST_LAPORAN PEMBAYARAN - {{ $container->nomor_container }}</title>
    <style>
        @page {
            size: landscape;
            margin: 10mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9pt;
            color: #000;
        }

        .bordered {
            border: 1px solid #000;
        }

        .collapse {
            border-collapse: collapse;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .table-data th {
            text-transform: uppercase;
            font-weight: bold;
            background-color: #fce4d6;
            /* Sedikit mirip kuning pudar/krem sbg pembeda header */
            text-align: center;
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

        @media print {
            body {
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <!-- Header Section -->
    @if(!isset($isExport))
        <table class="w-100 collapse" style="border-bottom: 2px solid #000; margin-bottom: 10px; padding-bottom: 5px;">
            <tr>
                <td style="width: 25%; vertical-align: middle; padding: 5px;">
                    <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo"
                        style="max-height: 80px; max-width: 150px; object-fit: contain;">
                </td>
                <td style="width: 75%; vertical-align: top; text-align: right; padding: 5px;">
                    <h1 style="margin: 0 0 5px 0; font-family: 'Arial', sans-serif; font-size: 20pt; font-weight: bold;">
                        PT. SINAR <span style="color: red;">CEMARA</span> JAYA</h1>
                    <div style="font-size: 10pt; font-weight: bold; line-height: 1.3;">
                        JL. Swasembada Timur XIII No.32 C, Kel. Kebon Bawang, Kec. Tanjung Priok<br>
                        Jakarta Utara 14320 | Email: sinarcemarajaya@gmail.com<br>
                        <a href="http://www.sinarcemarajaya.com"
                            style="color: blue; text-decoration: underline;">www.sinarcemarajaya.com</a>
                    </div>
                </td>
            </tr>
        </table>
    @endif

    <h2 class="text-center" style="font-size: 14pt; font-weight: bold; margin: 10px 0;">CONTAINER COST_LAPORAN
        PEMBAYARAN
    </h2>

    <table class="w-100 collapse" style="margin-bottom: 15px; font-size: 10pt;">
        <tr>
            <td style="width: 15%; padding: 2px; font-weight:bold;">Nama Kapal</td>
            <td style="width: 35%; padding: 2px;">: {{ $container->kapal->nama_kapal ?? '-' }}</td>
            <td style="width: 15%; padding: 2px; font-weight:bold;">Pelabuhan Asal</td>
            <td style="width: 35%; padding: 2px;">: {{ $container->asal->nama_tujuan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 2px; font-weight:bold;">Tgl Keberangkatan (ETD)</td>
            <td style="padding: 2px;">:
                {{ $container->etd ? Carbon\Carbon::parse($container->etd)->translatedFormat('d F Y') : '-' }}
            </td>
            <td style="padding: 2px; font-weight:bold;">Pelabuhan Tujuan</td>
            <td style="padding: 2px;">: {{ $container->tujuan->nama_tujuan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 2px; font-weight:bold;">Contr / Seal</td>
            <td style="padding: 2px;">: {{ $container->nomor_container }}</td>
            <td style="padding: 2px; font-weight:bold;">Tipe Kontainer</td>
            <td style="padding: 2px;">: {{ $container->tipe_kontainer ?? '-' }}</td>
        </tr>
    </table>

    <!-- Table Data Invoice -->
    <table class="w-100 collapse table-data" {{ isset($isExport) ? 'border="1"' : '' }}>
        <thead>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>No</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>No Invoice</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Tgl Masuk</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Pengirim</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Penerima</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Daerah Tujuan</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }} style="min-width: 80px;">Jenis
                Barang</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Koli</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Jumlah</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Sat</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Harga Satuan</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Sub Total</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>DPP</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>TOTAL</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Tanda Terima</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>Status</th>
            <th {{ isset($isExport) ? 'style="background-color: #fce4d6;"' : '' }}>STTS PKP</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $totalJumlah = 0;
                $grandTotalAll = 0;
            @endphp
            @forelse ($container->invoices as $inv)
                @php
                    $rowCount = $inv->items->count() > 0 ? $inv->items->count() : 1;
                    $dpp_base = $inv->items->sum(function($item) {
                        return $item->jumlah * $item->harga_satuan;
                    });
                    $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
                    $dpp_and_fee_val = $dpp_base + $fee_val;
                    $is_pkp = strtoupper($inv->pkp_status) == 'PKP';

                    $ppn_val = $is_pkp ? $dpp_and_fee_val * 0.011 : 0;
                    $dpp_display = $dpp_and_fee_val;
                    $grand_total_val = round($dpp_and_fee_val + $ppn_val);

                    if ($inv->items) {
                        foreach($inv->items as $item) {
                            if (strtolower($item->satuan) != 'unit') {
                                $totalJumlah += $item->jumlah;
                            }
                        }
                    }
                    $grandTotalAll += $grand_total_val;
                @endphp
                <tr>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $no++ }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->no_invoice }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">
                        {{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d-M-Y') : '-' }}
                    </td>
                    <td rowspan="{{ $rowCount }}">{{ $inv->pengirim->nama ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}">{{ $inv->penerima->nama ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->tujuanDaerah->nama ?? '-' }}</td>

                    @if($inv->items->count() > 0)
                        <td>{{ $inv->items[0]->jenis_barang }}</td>
                        <td class="text-center">{{ $inv->items[0]->koli }}</td>
                        <td class="text-center">{{ number_format($inv->items[0]->jumlah, 3, ',', '.') }}
                        </td>
                        <td class="text-center">{{ $inv->items[0]->satuan }}</td>
                        <td class="text-right">{{ number_format($inv->items[0]->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($inv->items[0]->jumlah * $inv->items[0]->harga_satuan, 0, ',', '.') }}</td>
                    @else
                        <td>-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    @endif

                    <td rowspan="{{ $rowCount }}" class="text-right">{{ number_format($dpp_display, 0, ',', '.') }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-right">
                        {{ number_format($grand_total_val, 0, ',', '.') }}
                    </td>
                    <td rowspan="{{ $rowCount }}" class="text-center" style="{{ strtoupper($inv->tanda_terima ?? '') == 'PENGIRIM' ? 'color: red; font-weight: bold;' : '' }}">
                        {{ strtoupper($inv->tanda_terima ?? '-') }}
                    </td>
                    <td rowspan="{{ $rowCount }}" class="text-center" style="{{ strtoupper($inv->status_pembayaran ?? '') == 'TAHAN' ? 'color: red; font-weight: bold;' : '' }}">
                        {{ strtoupper($inv->status_pembayaran ?? '-') }}
                    </td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ mb_strtoupper($inv->pkp_status) }}</td>
                </tr>
                @if($inv->items->count() > 1)
                    @for($i = 1; $i < $rowCount; $i++)
                        <tr>
                            <td>{{ $inv->items[$i]->jenis_barang }}</td>
                            <td class="text-center">{{ $inv->items[$i]->koli }}</td>
                            <td class="text-center">
                                {{ number_format($inv->items[$i]->jumlah, 3, ',', '.') }}
                            </td>
                            <td class="text-center">{{ $inv->items[$i]->satuan }}</td>
                            <td class="text-right">{{ number_format($inv->items[$i]->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($inv->items[$i]->jumlah * $inv->items[$i]->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @endfor
                @endif
            @empty
                <tr>
                    <td colspan="18" class="text-center" style="padding: 15px;">Belum ada invoice di dalam container ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f2f2f2; font-weight: bold;">
                <td colspan="8" class="text-right">TOTAL JUMLAH</td>
                <td class="text-center">{{ number_format($totalJumlah, 3, ',', '.') }}</td>
                <td colspan="9"></td>
            </tr>
            <tr style="background-color: #e2e2e2; font-weight: bold;">
                <td colspan="8" class="text-right">GRAND TOTAL</td>
                <td colspan="5"></td>
                <td class="text-right nowrap">Rp {{ number_format($grandTotalAll, 0, ',', '.') }}</td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>

    @php
        $totalPendapatan = 0;
        foreach ($container->invoices as $inv) {
            $dpp_base = $inv->items->sum('subtotal');
            $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
            $dpp_and_fee_val = $dpp_base + $fee_val;
            $is_pkp = strtoupper($inv->pkp_status) == 'PKP';
            $ppn_val = $is_pkp ? $dpp_and_fee_val * 0.011 : 0;
            $totalPendapatan += ($dpp_and_fee_val + $ppn_val);
        }

        if ($container->total_pembayaran_manual > 0) {
            $totalPendapatan = $container->total_pembayaran_manual;
        }

        $totalPengeluaran = $container->operationalCosts->sum('nominal');
        $totalProfit = $totalPendapatan - $totalPengeluaran;
    @endphp

    <div style="margin-top: 20px; display: flex; gap: 40px; align-items: flex-start;">
        <!-- Left Column: Operational Costs -->
        <div style="width: 45%;">
            <table class="w-100 collapse table-data">
                <thead>
                    <tr>
                        <th colspan="4" style="background-color: #e2efda; font-weight: bold;">RINCIAN BIAYA OPERASIONAL</th>
                    </tr>
                    <tr>
                        <th style="background-color: #eeece1; width: 30px;">No</th>
                        <th style="background-color: #eeece1;">Komponen Biaya</th>
                        <th style="background-color: #eeece1;">Nominal (Rp)</th>
                        <th style="background-color: #eeece1;">Tgl Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($container->operationalCosts as $opIndex => $op)
                        <tr>
                            <td class="text-center">{{ $opIndex + 1 }}</td>
                            <td>{{ $op->komponen }}</td>
                            <td class="text-right">{{ number_format($op->nominal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                {{ $op->tanggal_transfer ? \Carbon\Carbon::parse($op->tanggal_transfer)->format('d-M-Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada rincian biaya operasional.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="font-bold">
                        <td colspan="2" class="text-right" style="background-color: #fce4d6;">Total Pengeluaran</td>
                        <td class="text-right" style="background-color: #fce4d6;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td style="background-color: #fce4d6;"></td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="2" class="text-right" style="background-color: #d9e1f2;">Total Pendapatan</td>
                        <td class="text-right" style="background-color: #d9e1f2;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td style="background-color: #d9e1f2;"></td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="2" class="text-right" style="background-color: #fff2cc;">TOTAL PROFIT</td>
                        <td class="text-right" style="background-color: #fff2cc;">Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
                        <td style="background-color: #fff2cc;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Right Column: Note -->
        @if(!empty($container->catatan_finance))
            <div style="width: 35%; padding: 10px; border: 1px solid #000; min-height: 80px;">
                <strong>Catatan Finance:</strong><br>
                <div style="margin-top: 5px;">
                    {!! nl2br(e($container->catatan_finance)) !!}
                </div>
            </div>
        @endif
    </div>

    <div class="text-center no-print" style="margin-top: 30px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #0d6efd; border: none; color: white; border-radius: 4px; margin-right: 10px;">Cetak
            Manifest</button>
        <button onclick="window.close()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #6c757d; border: none; color: white; border-radius: 4px;">Tutup</button>
    </div>
</body>

</html>