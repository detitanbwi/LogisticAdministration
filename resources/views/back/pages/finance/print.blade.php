<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>LAPORAN PEMBAYARAN FINANCE - {{ $finance->invoice->no_invoice }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 9pt;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .header-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            border: 2px solid #333;
            padding: 10px;
            margin-bottom: 25px;
            text-transform: uppercase;
            background-color: #f8f9fa;
            color: #2c3e50;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .main-container {
            display: flex;
            gap: 20px;
            align-items: stretch; /* This ensures columns have equal height */
        }

        .column {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0; /* Changed to 0 to manage spacing via containers if needed */
        }

        th, td {
            border: 1px solid #000;
            padding: 3px 6px;
            vertical-align: top;
            line-height: 1.2;
        }

        th {
            background-color: #eeece1; /* Professional beige/grey */
            text-align: center;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            font-size: 9pt;
            padding: 5px 6px;
        }

        .section-header-orange {
            background-color: #fcd5b4 !important; /* Light Orange */
            font-weight: bold;
            text-align: center;
        }

        .section-header-blue {
            background-color: #d9e1f2 !important; /* Light Blue */
            font-weight: bold;
            text-align: center;
        }

        .section-header-green {
            background-color: #e2efda !important; /* Light Green */
            font-weight: bold;
            text-align: center;
        }

        .label-cell {
            width: 45%;
            font-weight: 600;
            background-color: #fdfdfd;
        }

        .value-cell {
            width: 55%;
        }

        .bg-yellow {
            background-color: #ffff00 !important;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .notes-container {
            flex-grow: 1; /* This fills the remaining space */
            border: 1px solid #000;
            margin-top: -1px; /* Overlap with table bottom border */
            padding: 8px;
            background-color: #fff;
            display: block;
            min-height: 60px; /* Minimum space for notes */
        }

        .notes-label {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            display: block;
            font-size: 9pt;
        }

        @media print {
            body {
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
            .header-title {
                box-shadow: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    @php
        $invoice = $finance->invoice;
        $dpp = $invoice->items->sum('subtotal');
        $feeTotal = $invoice->additionalFees ? $invoice->additionalFees->sum('harga') : 0;
        $totalDpp = $dpp + $feeTotal;
        $is_pkp = strtoupper($invoice->pkp_status) == 'PKP';
        $ppn = $is_pkp ? $totalDpp * 0.011 : 0;
        $grandTotal = $totalDpp + $ppn;

        $today = \Carbon\Carbon::now()->startOfDay();
        $tagih = $finance->tanggal_tagih ? \Carbon\Carbon::parse($finance->tanggal_tagih)->startOfDay() : null;
        $masaTunggakan = '-';
        if ($tagih) {
            if ($finance->tgl_transfer) {
                $masaTunggakan = 'Lunas';
            } else {
                $diffDays = $tagih->diffInDays($today, false);
                $masaTunggakan = ($diffDays > 0 ? intval($diffDays) . ' Hari' : '-');
            }
        }
    @endphp

    <div class="header-title">LAPORAN PEMBAYARAN FINANCE</div>

    <div class="main-container">
        <!-- Column 1: Detail Invoice -->
        <div class="column">
            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header-blue">Detail Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label-cell">No Invoice</td>
                        <td class="value-cell">: {{ $invoice->no_invoice }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Tanggal masuk</td>
                        <td>: {{ $invoice->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Pengirim</td>
                        <td>: {{ optional($invoice->pengirim)->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">No HP pengirim</td>
                        <td>: {{ optional($invoice->pengirim)->no_hp }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Alamat pengirim</td>
                        <td>: {{ optional($invoice->pengirim)->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">No. NPWP pengirim</td>
                        <td>: {{ optional($invoice->pengirim)->npwp }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Penerima</td>
                        <td>: {{ optional($invoice->penerima)->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">No HP penerima</td>
                        <td>: {{ optional($invoice->penerima)->no_hp }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Alamat penerima</td>
                        <td>: {{ optional($invoice->penerima)->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">No. NPWP penerima</td>
                        <td>: {{ optional($invoice->penerima)->npwp }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Up</td>
                        <td>: {{ optional($invoice->upDetail)->nama }}</td>
                    </tr>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="label-cell font-bold">Jenis barang</td>
                        <td>: {{ $item->jenis_barang }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Jumlah koli</td>
                        <td>: {{ $item->koli }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Jumlah barang</td>
                        <td>: {{ rtrim(rtrim(number_format($item->jumlah, 3, ',', '.'), '0'), ',') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Satuan jumlah barang</td>
                        <td>: {{ $item->satuan }}</td>
                    </tr>
                    @endforeach

                    @foreach($invoice->additionalFees as $fee)
                    <tr>
                        <td class="label-cell font-bold">Biaya Tambahan</td>
                        <td>: {{ $fee->nama }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td class="label-cell">Tanda terima</td>
                        <td>: {{ $invoice->tanda_terima }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Status Tahan-serahkan</td>
                        <td>: {{ $invoice->status_pembayaran }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Layanan</td>
                        <td>: {{ $invoice->layanan }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">BAP balik</td>
                        <td>: {{ $finance->bap_balik }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Tujuan daerah</td>
                        <td>: {{ optional($invoice->tujuanDaerah)->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">PKP/ Non PKP</td>
                        <td>: {{ $invoice->pkp_status }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="notes-container">
                <span class="notes-label">Catatan Invoice</span>
                {{ $invoice->catatan_muntahan }}
            </div>
        </div>

        <!-- Column 2: Kapal & Kontainer + Detail Pembayaran -->
        <div class="column">
            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header-green">Kapal dan Kontainer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label-cell">Pelabuhan asal</td>
                        <td class="value-cell">: {{ optional($invoice->container->asal)->nama_tujuan }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Pelabuhan tujuan</td>
                        <td>: {{ optional($invoice->container->tujuan)->nama_tujuan }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Nama kapal</td>
                        <td>: {{ optional($invoice->container->kapal)->nama_kapal }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">ETD</td>
                        <td>: {{ $invoice->container && $invoice->container->etd ? $invoice->container->etd->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">ETA</td>
                        <td>: {{ $invoice->container && $invoice->container->eta ? $invoice->container->eta->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Container/seal</td>
                        <td>: {{ optional($invoice->container)->nomor_container }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Metode</td>
                        <td>: {{ $invoice->metode }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Tipe container</td>
                        <td>: {{ optional($invoice->container)->tipe_kontainer }}</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header-orange">Detail Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="label-cell font-bold">Jenis barang</td>
                        <td class="value-cell font-bold">: {{ $item->jenis_barang }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Harga satuan</td>
                        <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Sub total harga</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    @foreach($invoice->additionalFees as $fee)
                    <tr>
                        <td class="label-cell font-bold">Biaya Tambahan</td>
                        <td class="value-cell font-bold">: {{ $fee->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Sub total harga</td>
                        <td class="text-right">Rp {{ number_format($fee->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td class="label-cell font-bold">DPP</td>
                        <td class="text-right font-bold">Rp {{ number_format($totalDpp, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell font-bold">PKP 1,1%</td>
                        <td class="text-right font-bold">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-yellow">
                        <td class="label-cell font-bold">Total tagihan</td>
                        <td class="text-right font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Terima barang</td>
                        <td>: {{ $invoice->terima_barang ? \Carbon\Carbon::parse($invoice->terima_barang)->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Ditagih ke</td>
                        <td>: {{ $finance->ditagih_ke }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Status tagihan</td>
                        <td>: {{ $finance->status_tagihan }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Tanggal transfer</td>
                        <td>: {{ $finance->tgl_transfer ? \Carbon\Carbon::parse($finance->tgl_transfer)->format('d-m-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Masa tunggakan</td>
                        <td>: {{ $masaTunggakan }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="notes-container">
                <span class="notes-label">Catatan Finance</span>
                {{ $finance->catatan }}
            </div>
        </div>
    </div>
    </div>

    <div class="text-center no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #0d6efd; border: none; color: white; border-radius: 4px; margin-right: 10px;">Cetak
            Summary</button>
        <button onclick="window.close()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #6c757d; border: none; color: white; border-radius: 4px;">Tutup</button>
    </div>
</body>

</html>
