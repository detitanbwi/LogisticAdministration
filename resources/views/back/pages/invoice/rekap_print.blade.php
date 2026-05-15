<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ str_replace(' ', '_', $filters['judul_print']) . '_' . date('Ymd_His') }}</title>
    <style>
        @page { size: landscape; margin: 10mm; }
        body { font-family: 'Arial', sans-serif; font-size: 9pt; color: #333; margin: 0; padding: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10pt; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 5px 3px; text-align: left; word-wrap: break-word; font-size: 8pt; vertical-align: middle; }
        th { background-color: #8B4513; color: white; font-weight: bold; text-align: center; text-transform: uppercase; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .nowrap { white-space: nowrap; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            th { background-color: #8B4513 !important; color: white !important; }
            tfoot tr { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }

        .btn-print {
            padding: 8px 16px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 15px;
            font-size: 10pt;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right;">
        <button class="btn-print" onclick="window.print()">CETAK PDF / PRINT</button>
        <button class="btn-print" style="background: #6c757d;" onclick="window.close()">TUTUP</button>
    </div>

    <div class="header">
        <h1>{{ $filters['judul_print'] }}</h1>
        <p>Periode: {{ $filters['daterange'] ?: 'Semua Tanggal' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 55px;">No Invoice</th>
                <th style="width: 70px;">ETD</th>
                <th style="width: 120px;">Pengirim</th>
                <th style="width: 120px;">Penerima</th>
                <th style="width: 35px;">Koli</th>
                <th style="width: 60px;">Jumlah</th>
                <th style="width: 50px;">Satuan</th>
                <th style="width: 100px;">Tagihan</th>
                <th style="width: 60px;">Tanda Terima</th>
                <th style="width: 60px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $globalNo = 1; 
                $totalJumlah = 0;
                $totalTagihanAll = 0;
            @endphp
            @forelse($invoices as $inv)
                @php 
                    $items = $inv->items;
                    $rowCount = count($items) > 0 ? count($items) : 1;
                    
                    // Recalculate on-the-fly
                    // Recalculate on-the-fly with consistent rounding
                    $dpp_base = $items->sum(function($item) {
                        if (strtoupper($item->satuan) == 'UNIT') {
                            return $item->koli * $item->harga_satuan;
                        }
                        return $item->jumlah * $item->harga_satuan;
                    });
                    $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
                    $totalTagihan = $dpp_base + $fee_val;
                    if (strtoupper($inv->pkp_status) == 'PKP') {
                        $totalTagihan += $totalTagihan * 0.011;
                    }
                @endphp
                @if(count($items) > 0)
                    @php 
                        $totalTagihanAll += $totalTagihan;
                    @endphp
                    @foreach($items as $index => $item)
                        <tr>
                            @if($index === 0)
                                <td rowspan="{{ $rowCount }}" class="text-center">{{ $globalNo++ }}</td>
                                <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->no_invoice }}</td>
                                <td rowspan="{{ $rowCount }}" class="text-center nowrap">{{ $inv->container && $inv->container->etd ? $inv->container->etd->format('d-M-Y') : '-' }}</td>
                                <td rowspan="{{ $rowCount }}">{{ $inv->pengirim->nama ?? '-' }}</td>
                                <td rowspan="{{ $rowCount }}">{{ $inv->penerima->nama ?? '-' }}</td>
                            @endif
                            @php 
                                if (strtoupper($item->satuan) != 'UNIT') {
                                    $totalJumlah += $item->jumlah;
                                }
                            @endphp
                            <td class="text-center">{{ $item->koli }}</td>
                            @php
                                $val = (float)$item->jumlah;
                                $factor = pow(10, 3);
                                $truncated = floor($val * $factor) / $factor;
                            @endphp
                            <td class="text-center">{{ number_format($truncated, 3, ',', '.') }}</td>
                            <td class="text-center">{{ $item->satuan }}</td>
                            @if($index === 0)
                                <td rowspan="{{ $rowCount }}" class="text-right nowrap">
                                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                                </td>
                                <td rowspan="{{ $rowCount }}" class="text-center" style="{{ strtoupper($inv->tanda_terima ?? '') == 'PENGIRIM' ? 'color: red; font-weight: bold;' : '' }}">
                                    {{ strtoupper($inv->tanda_terima ?? 'SCJ') }}
                                </td>
                                <td rowspan="{{ $rowCount }}" class="text-center" style="{{ strtoupper($inv->status_pembayaran ?? '') == 'TAHAN' ? 'color: red; font-weight: bold;' : '' }}">
                                    {{ strtoupper($inv->status_pembayaran ?? '-') }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">{{ $globalNo++ }}</td>
                        <td class="text-center">{{ $inv->no_invoice }}</td>
                        <td class="text-center nowrap">{{ $inv->container && $inv->container->etd ? $inv->container->etd->format('d-M-Y') : '-' }}</td>
                        <td>{{ $inv->pengirim->nama ?? '-' }}</td>
                        <td>{{ $inv->penerima->nama ?? '-' }}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-right nowrap">
                            Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                        </td>
                        <td class="text-center" style="{{ strtoupper($inv->tanda_terima ?? '') == 'PENGIRIM' ? 'color: red; font-weight: bold;' : '' }}">
                            {{ strtoupper($inv->tanda_terima ?? 'SCJ') }}
                        </td>
                        <td class="text-center" style="{{ strtoupper($inv->status_pembayaran ?? '') == 'TAHAN' ? 'color: red; font-weight: bold;' : '' }}">
                            {{ strtoupper($inv->status_pembayaran ?? '-') }}
                        </td>
                    </tr>
                    @php 
                        $totalTagihanAll += $totalTagihan;
                    @endphp
                @endif
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #8B4513 !important; color: white !important; font-weight: bold; -webkit-print-color-adjust: exact;">
                <td colspan="6" class="text-right">TOTAL JUMLAH</td>
                <td class="text-center">{{ number_format($totalJumlah, 3, ',', '.') }}</td>
                <td colspan="4"></td>
            </tr>
            <tr style="background-color: #A0522D !important; color: white !important; font-weight: bold; -webkit-print-color-adjust: exact;">
                <td colspan="6" class="text-right">GRAND TOTAL</td>
                <td></td>
                <td></td>
                <td class="text-right nowrap">Rp {{ number_format($totalTagihanAll, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
