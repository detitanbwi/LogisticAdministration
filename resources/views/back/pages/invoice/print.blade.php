<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->no_invoice }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            padding: 20px;
            color: #000;
        }

        .bordered {
            border: 1px solid #000;
        }

        .collapse {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 6px;
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
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    @php
        function terbilang($angka)
        {
            $angka = abs($angka);
            $baca = [
                '',
                'Satu',
                'Dua',
                'Tiga',
                'Empat',
                'Lima',
                'Enam',
                'Tujuh',
                'Delapan',
                'Sembilan',
                'Sepuluh',
                'Sebelas',
            ];
            $terbilang = '';
            if ($angka < 12) {
                $terbilang = ' ' . $baca[$angka];
            } elseif ($angka < 20) {
                $terbilang = terbilang($angka - 10) . ' Belas';
            } elseif ($angka < 100) {
                $terbilang = terbilang($angka / 10) . ' Puluh' . terbilang($angka % 10);
            } elseif ($angka < 200) {
                $terbilang = ' Seratus' . terbilang($angka - 100);
            } elseif ($angka < 1000) {
                $terbilang = terbilang($angka / 100) . ' Ratus' . terbilang($angka % 100);
            } elseif ($angka < 2000) {
                $terbilang = ' Seribu' . terbilang($angka - 1000);
            } elseif ($angka < 1000000) {
                $terbilang = terbilang($angka / 1000) . ' Ribu' . terbilang($angka % 1000);
            } elseif ($angka < 1000000000) {
                $terbilang = terbilang($angka / 1000000) . ' Juta' . terbilang($angka % 1000000);
            } elseif ($angka < 1000000000000) {
                $terbilang = terbilang($angka / 1000000000) . ' Milyar' . terbilang(fmod($angka, 1000000000));
            }
            return trim($terbilang);
        }

        $dpp = $invoice->items->sum('subtotal');
        $ppn = $invoice->pkp_status == 'PKP' ? $dpp * 0.011 : 0;
        $grandTotal = $dpp + $ppn;

        // Parse layanan
        $layananParts = explode(' to ', strtolower($invoice->layanan ?? 'cy to door'));
        $part1 = strtoupper(trim($layananParts[0] ?? 'CY'));
        $part2 = strtoupper(trim($layananParts[1] ?? 'DOOR'));
        if (strtolower($invoice->layanan) == 'door to door') {
            $part1 = 'DOOR';
            $part2 = 'DOOR';
        }
        if (strtolower($invoice->layanan) == 'cy to cy') {
            $part1 = 'CY';
            $part2 = 'CY';
        }
        if (strtolower($invoice->layanan) == 'port to port') {
            $part1 = 'PORT';
            $part2 = 'PORT';
        }
    @endphp

    <div style="max-width: 950px; margin: 0 auto; background: #fff; padding: 10px;">
        <!-- Header Section -->
        <table class="w-100 collapse" style="border-bottom: 1px solid #000; margin-bottom: 5px;">
            <tr>
                <td style="width: 20%; vertical-align: middle; padding: 5px;">
                    <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo"
                        style="max-height: 100px; max-width: 150px; object-fit: contain;">
                </td>
                <td style="width: 80%; vertical-align: top; text-align: right; padding: 5px;">
                    <h1
                        style="margin: 0 0 5px 0; font-family: 'Arial', sans-serif; font-size: 24pt; font-weight: bold;">
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

        <h2 class="text-center" style="font-size: 18pt; font-weight: bold; margin: 5px 0;">INVOICE</h2>

        <!-- Invoice Info -->
        <table class="w-100 collapse" style="margin-bottom: 5px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; font-size: 10.5pt;">
                        <tr>
                            <td style="width: 150px; padding: 2px;">No. Invoice</td>
                            <td>: {{ $invoice->no_invoice }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Tanggal Invoice</td>
                            <td>: {{ Carbon\Carbon::parse($invoice->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Status PKP</td>
                            <td>: {{ $invoice->pkp_status ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Metode</td>
                            <td>: {{ $invoice->metode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Pelabuhan Asal</td>
                            <td>: {{ $invoice->container->asal->nama_tujuan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Tujuan</td>
                            <td>: {{ $invoice->container->tujuan->nama_tujuan ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; font-size: 10.5pt;">
                        <tr>
                            <td style="width: 120px; padding: 2px;">Kapal</td>
                            <td>: {{ $invoice->container->kapal->nama_kapal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">ETD</td>
                            <td>:
                                {{ $invoice->container && $invoice->container->etd ? Carbon\Carbon::parse($invoice->container->etd)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">ETA</td>
                            <td>:
                                {{ $invoice->container && $invoice->container->eta ? Carbon\Carbon::parse($invoice->container->eta)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Kontainer</td>
                            <td>: {{ $invoice->container->tipe_kontainer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Contr/Seal</td>
                            <td>: {{ $invoice->container->nomor_container ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Layanan</td>
                            <td>: {{ strtoupper($invoice->layanan ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Up</td>
                            <td>: {{ $invoice->upDetail->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Sender / Receiver Section -->
        <table class="w-100 collapse bordered" style="margin-bottom: 5px;">
            <tr>
                <td style="width: 50%; border: 1px solid #000; padding: 3px 5px;">
                    <div class="font-bold"
                        style="border-bottom: 1px solid #000; padding-bottom: 2px; margin-bottom: 2px; font-size: 10.5pt;">
                        PENGIRIM</div>
                    <div style="font-size: 10.5pt;">{{ $invoice->pengirim->nama }}<br>
                        {{ $invoice->pengirim->alamat }}<br>
                        HP : {{ $invoice->pengirim->no_hp }}</div>
                </td>
                <td style="width: 50%; border: 1px solid #000; padding: 3px 5px;">
                    <div class="font-bold"
                        style="border-bottom: 1px solid #000; padding-bottom: 2px; margin-bottom: 2px; font-size: 10.5pt;">
                        PENERIMA</div>
                    <div style="font-size: 10.5pt;">{{ $invoice->penerima->nama }}<br>
                        {{ $invoice->penerima->alamat }}<br>
                        HP : {{ $invoice->penerima->no_hp }}</div>
                </td>
            </tr>
        </table>

        <div class="text-center font-bold" style="font-size: 11pt; margin: 8px 0;">
            <div style="display: flex; justify-content: space-around; width: 100%;">
                <span>{{ $part1 }}</span>
                <span>TO</span>
                <span>{{ $part2 }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <table class="w-100 collapse bordered" style="margin-bottom: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #000; font-size: 11pt;">
                    <th style="width: 5%; border: 1px solid #000;" class="text-center font-bold">No</th>
                    <th style="width: 35%; border: 1px solid #000;" class="text-center font-bold">Jenis Barang</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Koli</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Qty</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Satuan</th>
                    <th style="width: 15%; border: 1px solid #000;" class="text-center font-bold">Harga Satuan</th>
                    <th style="width: 15%; border: 1px solid #000;" class="text-center font-bold">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td class="text-center" style="border: 1px solid #000;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #000;">{{ $item->jenis_barang }}</td>
                        <td class="text-center font-bold" style="border: 1px solid #000;">{{ $item->koli }}</td>
                        <td class="text-center" style="border: 1px solid #000;">
                            {{ rtrim(rtrim(number_format($item->jumlah, 3, ',', '.'), '0'), ',') }}
                        </td>
                        <td class="text-center" style="border: 1px solid #000;">{{ $item->satuan }}</td>
                        <td style="border: 1px solid #000;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Rp</span>
                                <span>{{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td style="border: 1px solid #000;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Rp</span>
                                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Subtotal / PPN / Total block -->
        <table class="w-100 collapse font-bold" style="font-size: 11pt;">
            <tr>
                <td rowspan="3" style="width: 60%; vertical-align: bottom; position: relative;">
                    <!-- Bank Account Info -->
                    <div style="text-align: center; margin-bottom: 5px;">
                        BANK BCA<br>
                        0072579401<br>
                        PT.SINAR CEMARA JAYA
                    </div>
                </td>
                <td style="width: 20%; padding: 5px 10px;">Total DPP</td>
                <td style="width: 5%; padding: 5px 0 5px 5px; color: red;">Rp</td>
                <td class="text-right" style="width: 15%; padding: 5px 10px 5px 0; color: red;">
                    {{ number_format($dpp, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 10px;">PKP</td>
                <td style="padding: 5px 0 5px 5px; color: red;">Rp</td>
                <td class="text-right" style="padding: 5px 10px 5px 0; color: red;">
                    {{ $ppn > 0 ? number_format($ppn, 0, ',', '.') : '-' }}
                </td>
            </tr>
            <tr style="background-color: yellow;">
                <td class="text-center" style="padding: 5px 10px; border: 1px solid #000; border-right: none;">TOTAL
                </td>
                <td style="padding: 5px 0 5px 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;">Rp</td>
                <td class="text-right" style="padding: 5px 10px 5px 0; border: 1px solid #000; border-left: none;">
                    {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <br>

        <!-- Terbilang Block -->
        <table class="w-100 collapse bordered font-bold italic"
            style="border: 1px solid #000; font-style: italic; margin-bottom: 10px; background-color: #d9e1f2;">
            <tr>
                <td style="width: 20%; padding: 4px 10px; border-right: 1px solid #000;">Terbilang :</td>
                <td class="text-center" style="padding: 4px 10px;">
                    {{ terbilang($grandTotal) }} Rupiah
                </td>
            </tr>
        </table>



        <!-- Footer notes and signature -->
        <table class="w-100 collapse">
            <tr>
                <td style="width: 60%; vertical-align: top; padding: 0;">
                    <div style="font-size: 11pt; font-weight: bold; line-height: 1.5;">
                        1. Harga tersebut belum termasuk biaya ASURANSI.<br>
                        2. Pemilik barang bertanggung jawab untuk mengasuransikan BARANG yang dikirim.<br>
                        3. Apabila terjadi huru-hara, bencana alam, kapal tenggelam, atau kejadian lain di luar kendali,
                        maka hal tersebut bukan menjadi tanggung jawab PT Sinar Cemara Jaya.<br>
                        4. NPWP 94.723.616.2-043.000
                    </div>
                </td>
                <td style="width: 40%; vertical-align: bottom; text-align: center; padding: 0;">
                    <div style="position: relative; display: inline-block;">
                        <img src="{{ asset('back/assets/images/stampel.png') }}"
                            style="width: 140px; position: absolute; top: -50px; left: 50%; transform: translateX(-50%); z-index: 1;">
                        <div class="font-bold text-center"
                            style="position: relative; z-index: 2; color: #d32f2f; font-size: 11pt; margin-top: 60px; margin-bottom: 2px;">
                            PT. SINAR
                            CEMARA JAYA</div>
                        <div class="font-bold text-center" style="position: relative; z-index: 2; font-size: 12pt;">
                            Zulkifli</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="text-center no-print" style="margin-top: 30px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #0d6efd; border: none; color: white; border-radius: 4px; margin-right: 10px;">Cetak
            Nota</button>
        <button onclick="window.close()"
            style="padding: 10px 20px; font-size: 14px; cursor: pointer; background: #6c757d; border: none; color: white; border-radius: 4px;">Tutup</button>
    </div>
</body>

</html>