<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manifest Container - {{ $container->nomor_container }}</title>
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

    <h2 class="text-center" style="font-size: 14pt; font-weight: bold; margin: 10px 0;">MANIFEST CONTAINER_PACKING LIST
    </h2>

    <table class="w-100 collapse" style="margin-bottom: 15px; font-size: 10pt;">
        <tr>
            <td style="width: 15%; padding: 2px; font-weight:bold;">Nama Kapal</td>
            <td style="width: 35%; padding: 2px;">: {{ $container->kapal->nama_kapal ?? '-' }}</td>
            <td style="width: 15%; padding: 2px; font-weight:bold;">Lokasi Asal</td>
            <td style="width: 35%; padding: 2px;">: {{ $container->asal->nama_tujuan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 2px; font-weight:bold;">Tgl Keberangkatan (ETD)</td>
            <td style="padding: 2px;">:
                {{ $container->etd ? Carbon\Carbon::parse($container->etd)->translatedFormat('d F Y') : '-' }}</td>
            <td style="padding: 2px; font-weight:bold;">Lokasi Tujuan</td>
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
    <table class="w-100 collapse table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Tgl Masuk</th>
                <th>Pengirim</th>
                <th>No HP Pengirim</th>
                <th>Penerima</th>
                <th>No HP Penerima</th>
                <th>Jenis Barang</th>
                <th>Koli</th>
                <th>Jumlah</th>
                <th>Sat</th>
                <th>BAP BALIK</th>
                <th>Status Pembayaran</th>
                <th>Layanan</th>
                <th>PKP / Non PKP</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($container->invoices as $inv)
                @php
                    $rowCount = $inv->items->count() > 0 ? $inv->items->count() : 1;
                @endphp
                <tr>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $no++ }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->no_invoice }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">
                        {{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d/m/Y') : '-' }}</td>
                    <td rowspan="{{ $rowCount }}">{{ $inv->pengirim->nama ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->pengirim->no_hp ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}">{{ $inv->penerima->nama ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->penerima->no_hp ?? '-' }}</td>

                    @if($inv->items->count() > 0)
                        <td>{{ $inv->items[0]->jenis_barang }}</td>
                        <td class="text-center">{{ $inv->items[0]->koli }}</td>
                        <td class="text-center">{{ rtrim(rtrim(number_format($inv->items[0]->jumlah, 3, ',', '.'), '0'), ',') }}
                        </td>
                        <td class="text-center">{{ $inv->items[0]->satuan }}</td>
                    @else
                        <td>-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    @endif

                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->terima_barang ? 'SUDAH' : 'BELUM' }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ $inv->status_pembayaran ?? '-' }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ strtoupper($inv->layanan ?? '-') }}</td>
                    <td rowspan="{{ $rowCount }}" class="text-center">{{ mb_strtoupper($inv->pkp_status) }}</td>
                </tr>
                @if($inv->items->count() > 1)
                    @for($i = 1; $i < $rowCount; $i++)
                        <tr>
                            <td>{{ $inv->items[$i]->jenis_barang }}</td>
                            <td class="text-center">{{ $inv->items[$i]->koli }}</td>
                            <td class="text-center">
                                {{ rtrim(rtrim(number_format($inv->items[$i]->jumlah, 3, ',', '.'), '0'), ',') }}</td>
                            <td class="text-center">{{ $inv->items[$i]->satuan }}</td>
                        </tr>
                    @endfor
                @endif
            @empty
                <tr>
                    <td colspan="15" class="text-center" style="padding: 15px;">Belum ada invoice di dalam container ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer Note -->
    @if(!empty($container->catatan_invoicing))
        <div style="margin-top: 15px; padding: 10px; border: 1px dotted #000; display: inline-block; vertical-align: top;">
            <strong>Catatan Invoicing:</strong><br>
            {!! nl2br(e($container->catatan_invoicing)) !!}
        </div>
    @endif
    
    @if(!empty($container->catatan_finance))
        <div style="margin-top: 15px; padding: 10px; border: 1px dotted #000; display: inline-block; vertical-align: top; margin-left: 10px;">
            <strong>Catatan Finance:</strong><br>
            {!! nl2br(e($container->catatan_finance)) !!}
        </div>
    @endif

    <div class="text-center no-print" style="margin-top: 30px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #0d6efd; border: none; color: white; border-radius: 4px; margin-right: 10px;">Cetak
            Manifest</button>
        <button onclick="window.close()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #6c757d; border: none; color: white; border-radius: 4px;">Tutup</button>
    </div>
</body>

</html>