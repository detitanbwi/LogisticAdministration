<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ str_replace(' ', '_', $filters['judul_print'] ?? 'REKAPITULASI FINANCE') . '_' . date('Ymd_His') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; margin: 1.25cm; }
        h2 { text-align: center; margin-bottom: 25px; text-transform: uppercase; }
        .filter-info { margin-bottom: 15px; }
        .filter-info p { margin: 2px 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; font-size: 10pt; }
        th { background-color: #8B4513 !important; color: white !important; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .nowrap { white-space: nowrap; }

        @media print { 
            .no-print { display: none; }
            body { margin: 0; padding: 10px; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; } 
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

    <h2>{{ $filters['judul_print'] ?? 'LAPORAN PEMBAYARAN REKAPITULASI FINANCE' }}</h2>
    <div class="filter-info">
        @if(request('asal_id'))
            <p><strong>Asal:</strong> {{ \App\Models\Pelabuhan::find(request('asal_id'))->nama_tujuan ?? '' }}</p>
        @endif
        @if(request('tujuan_id'))
            <p><strong>Tujuan:</strong> {{ \App\Models\Pelabuhan::find(request('tujuan_id'))->nama_tujuan ?? '' }}</p>
        @endif
        @if(request('daterange'))
            <p><strong>Periode:</strong> {{ request('daterange') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 100px;">No Invoice</th>
                <th>Pengirim</th>
                <th>Penerima</th>
                <th style="width: 110px;">Total Tagihan</th>
                <th style="width: 90px;">Status Tagihan</th>
                <th style="width: 80px;">Tanggal Tagih</th>
                <th style="width: 100px;">Masa Tunggakan</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $totalGrandTagihan = 0;
            @endphp
            @forelse($finances as $finance)
                @php 
                    $inv = $finance->invoice;
                    if(!$inv) continue;

                    $dpp_base = $inv->items ? $inv->items->sum(function($item) {
                        if (strtoupper($item->satuan) == 'UNIT') {
                            return $item->koli * $item->harga_satuan;
                        }
                        return $item->jumlah * $item->harga_satuan;
                    }) : 0;
                    $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
                    $dpp_and_fee_val = $dpp_base + $fee_val;
                    $is_pkp = strtoupper($inv->pkp_status) == 'PKP';
                    $ppn_val = $is_pkp ? $dpp_and_fee_val * 0.011 : 0;
                    $grand_total_val = round($dpp_and_fee_val + $ppn_val);

                    $totalGrandTagihan += $grand_total_val;

                    $masaText = '-';
                    if ($finance->tgl_transfer) {
                        $masaText = 'Lunas';
                    } else {
                        if ($finance->tanggal_tagih) {
                            $today = \Carbon\Carbon::now()->startOfDay();
                            $tagih = \Carbon\Carbon::parse($finance->tanggal_tagih)->startOfDay();
                            $diffDays = $tagih->diffInDays($today, false);
                            if ($diffDays > 0) {
                                $masaText = intval($diffDays) . ' Hari';
                            }
                        }
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $inv->no_invoice }}</td>
                    <td>{{ $inv->pengirim->nama ?? '-' }}</td>
                    <td>{{ $inv->penerima->nama ?? '-' }}</td>
                    <td class="text-right nowrap">Rp {{ number_format($grand_total_val, 0, ',', '.') }}</td>
                    <td class="text-center">{{ strtoupper($finance->status_tagihan ?? '-') }}</td>
                    <td class="text-center">{{ $finance->tanggal_tagih ? \Carbon\Carbon::parse($finance->tanggal_tagih)->translatedFormat('d-M-Y') : '-' }}</td>
                    <td class="text-center" style="{{ $masaText !== 'Lunas' ? 'color: red; font-weight: bold;' : '' }}">{{ $masaText }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada tagihan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #8B4513 !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                <td colspan="4" class="text-right">GRAND TOTAL</td>
                <td class="text-right nowrap">Rp {{ number_format($totalGrandTagihan, 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
