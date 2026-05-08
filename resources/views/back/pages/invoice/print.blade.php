<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $invoice->no_invoice }}</title>
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

        @page {
            size: portrait;
            margin: 0;
        }

        @media print {
            body {
                margin: 1.25cm;
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
            $angka = abs(round($angka));
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

            if ($angka == 0) {
                return '';
            } elseif ($angka < 12) {
                return $baca[$angka];
            } elseif ($angka < 20) {
                return terbilang($angka - 10) . ' Belas';
            } elseif ($angka < 100) {
                $sisa = $angka % 10;
                return terbilang(intval($angka / 10)) . ' Puluh' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 200) {
                $sisa = $angka - 100;
                return 'Seratus' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000) {
                $sisa = $angka % 100;
                return terbilang(intval($angka / 100)) . ' Ratus' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 2000) {
                $sisa = $angka - 1000;
                return 'Seribu' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000) {
                $sisa = $angka % 1000;
                return terbilang(intval($angka / 1000)) . ' Ribu' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000000) {
                $sisa = $angka % 1000000;
                return terbilang(intval($angka / 1000000)) . ' Juta' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            } elseif ($angka < 1000000000000) {
                $sisa = intval(fmod($angka, 1000000000));
                return terbilang(intval($angka / 1000000000)) . ' Milyar' . ($sisa > 0 ? ' ' . terbilang($sisa) : '');
            }
            return '';
        }

        $dpp = $invoice->items->sum('subtotal');
        $feeTotal = $invoice->additionalFees ? $invoice->additionalFees->sum('harga') : 0;
        $dpp_and_fee = $dpp + $feeTotal;
        $is_pkp = strtoupper($invoice->pkp_status) == 'PKP';
        $dpp_display = $dpp_and_fee;
        $ppn = $is_pkp ? round($dpp_and_fee * 0.011) : 0;
        $grandTotal = $dpp_and_fee + $ppn;

        // Parse layanan
        $layananName = $invoice->layanan->nama ?? '-';
        $layananParts = explode(' to ', strtolower($layananName));

        $displayParts = [];
        if (count($layananParts) > 1) {
            $displayParts[] = strtoupper(trim($layananParts[0]));
            $displayParts[] = 'TO';
            $displayParts[] = strtoupper(trim($layananParts[1]));
        } else {
            $words = explode(' ', strtoupper(trim($layananName)));
            foreach ($words as $word) {
                if (trim($word) !== '') {
                    $displayParts[] = $word;
                }
            }
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
                            <td style="width: 130px; padding: 2px; white-space: nowrap;">No. Invoice</td>
                            <td style="padding: 2px;">: {{ $invoice->no_invoice }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; white-space: nowrap;">Tanggal Invoice</td>
                            <td style="padding: 2px;">:
                                {{ Carbon\Carbon::parse($invoice->tgl_masuk ?? $invoice->created_at)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Status PKP</td>
                            <td style="padding: 2px;">: {{ $invoice->pkp_status ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Metode</td>
                            <td style="padding: 2px;">: {{ $invoice->metode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; white-space: nowrap;">Pelabuhan Asal</td>
                            <td style="padding: 2px;">: {{ $invoice->container->asal->nama_tujuan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; white-space: nowrap;">Pelabuhan Tujuan</td>
                            <td style="padding: 2px;">: {{ $invoice->container->tujuan->nama_tujuan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; white-space: nowrap;">Daerah Tujuan</td>
                            <td style="padding: 2px;">: {{ $invoice->tujuanDaerah->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; font-size: 10.5pt;">
                        <tr>
                            <td style="width: 75px; padding: 2px;">Kapal</td>
                            <td style="padding: 2px;">: {{ $invoice->container->kapal->nama_kapal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">ETD</td>
                            <td style="padding: 2px;">:
                                {{ $invoice->container && $invoice->container->etd ? Carbon\Carbon::parse($invoice->container->etd)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">ETA</td>
                            <td style="padding: 2px;">:
                                {{ $invoice->container && $invoice->container->eta ? Carbon\Carbon::parse($invoice->container->eta)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Kontainer</td>
                            <td style="padding: 2px;">: {{ $invoice->container->tipe_kontainer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Contr/Seal</td>
                            <td style="padding: 2px;">: {{ $invoice->container->nomor_container ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Layanan</td>
                            <td style="padding: 2px;">: {{ strtoupper($invoice->layanan->nama ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 2px;">Up</td>
                            <td style="padding: 2px;">: {{ $invoice->upDetail->nama ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Sender / Receiver Section -->
        <table class="w-100 collapse bordered" style="margin-bottom: 5px;">
            <tr>
                <td style="width: 50%; border: 1px solid #000; padding: 8px 12px;">
                    <div class="font-bold"
                        style="border-bottom: 1px solid #000; padding-bottom: 4px; margin-bottom: 4px; font-size: 12pt;">
                        PENGIRIM</div>
                    <div style="font-size: 12pt;">{{ optional($invoice->pengirim)->nama ?? '-' }}<br>
                        {{ optional($invoice->pengirim)->alamat ?? '-' }}<br>
                        HP : {{ optional($invoice->pengirim)->no_hp ?? '-' }}</div>
                </td>
                <td style="width: 50%; border: 1px solid #000; padding: 8px 12px;">
                    <div class="font-bold"
                        style="border-bottom: 1px solid #000; padding-bottom: 4px; margin-bottom: 4px; font-size: 12pt;">
                        PENERIMA</div>
                    <div style="font-size: 12pt;">{{ optional($invoice->penerima)->nama ?? '-' }}<br>
                        {{ optional($invoice->penerima)->alamat ?? '-' }}<br>
                        HP : {{ optional($invoice->penerima)->no_hp ?? '-' }}</div>
                </td>
            </tr>
        </table>

        <div class="text-center font-bold" style="font-size: 11pt; margin: 8px 0;">
            <div style="display: flex; justify-content: space-around; width: 100%;">
                @foreach($displayParts as $part)
                    <span>{{ $part }}</span>
                @endforeach
            </div>
        </div>

        <!-- Items Table -->
        <table class="w-100 collapse bordered" style="margin-bottom: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #000; font-size: 11pt;">
                    <th style="width: 5%; border: 1px solid #000;" class="text-center font-bold">No</th>
                    <th style="width: 35%; border: 1px solid #000;" class="text-center font-bold">Jenis Barang</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Koli</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Jumlah</th>
                    <th style="width: 10%; border: 1px solid #000;" class="text-center font-bold">Satuan</th>
                    <th style="width: 15%; border: 1px solid #000;" class="text-center font-bold">Harga Satuan</th>
                    <th style="width: 15%; border: 1px solid #000;" class="text-center font-bold">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td class="text-center" style="border: 1px solid #000;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #000;">
                            <div>{{ $item->jenis_barang }}</div>

                        </td>
                        <td class="text-center font-bold" style="border: 1px solid #000;">{{ $item->koli }}</td>
                        <td class="text-center" style="border: 1px solid #000;">
                            @php
                                $val = (float) $item->jumlah;
                                $factor = pow(10, 3);
                                $truncated = floor($val * $factor) / $factor;
                            @endphp
                            {{ number_format($truncated, 3, ',', '.') }}
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
                @if($invoice->additionalFees && $invoice->additionalFees->count() > 0)
                    @foreach($invoice->additionalFees as $feeIndex => $fee)
                        <tr>
                            <td class="text-center" style="border: 1px solid #000;">{{ count($invoice->items) + $feeIndex + 1 }}
                            </td>
                            <td colspan="4" style="border: 1px solid #000; padding-left: 5px;">Biaya Tambahan - {{ $fee->nama }}
                            </td>
                            <td style="border: 1px solid #000;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Rp</span>
                                    <span>{{ number_format($fee->harga, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td style="border: 1px solid #000;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Rp</span>
                                    <span>{{ number_format($fee->harga, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Subtotal / PPN / Total block -->
        <table class="w-100 collapse font-bold" style="font-size: 11pt;">
            <tr>
                <td rowspan="3" style="width: 60%; vertical-align: bottom; position: relative;">
                    <!-- Bank Account Info -->
                    <div style="text-align: center; margin-bottom: 5px;">
                        <div style="font-size: 11pt; line-height: 1.2;">
                            BANK BCA<br>
                            0072579401<br>
                            PT.SINAR CEMARA JAYA
                        </div>
                        <div style="color: #dc3545; font-weight: bold; font-size: 8pt; margin-top: 5px;">
                            PEMBAYARAN SELAIN KE REKENING DIATAS BUKAN TANGGUNGJAWAB PERUSAHAAN !
                        </div>
                    </div>
                </td>
                <td style="width: 20%; padding: 5px 10px;">Total DPP</td>
                <td style="width: 5%; padding: 5px 0 5px 5px; color: red;">Rp</td>
                <td class="text-right" style="width: 15%; padding: 5px 10px 5px 0; color: red;">
                    {{ number_format($dpp_display, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 10px;">PKP (1,1%)</td>
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
                    <h3 style="font-size: 11pt; font-weight: bold; margin: 0 0 5px 0;">Catatan</h3>
                    <table
                        style="width: 100%; border-collapse: collapse; font-size: 11pt; font-weight: bold; line-height: 1.4;">
                        <tr>
                            <td style="width: 25px; vertical-align: top; padding: 0;">1.</td>
                            <td style="vertical-align: top; padding: 0;">Harga tersebut belum termasuk biaya ASURANSI.
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25px; vertical-align: top; padding: 0;">2.</td>
                            <td style="vertical-align: top; padding: 0;">Pemilik barang bertanggung jawab untuk
                                mengasuransikan BARANG yang dikirim.</td>
                        </tr>
                        <tr>
                            <td style="width: 25px; vertical-align: top; padding: 0;">3.</td>
                            <td style="vertical-align: top; padding: 0;">Apabila terjadi huru-hara, bencana alam, kapal
                                tenggelam, atau kejadian lain di luar kendali, maka hal tersebut bukan menjadi tanggung
                                jawab PT Sinar Cemara Jaya.</td>
                        </tr>
                        <tr>
                            <td style="width: 25px; vertical-align: top; padding: 0;">4.</td>
                            <td style="vertical-align: top; padding: 0; color: red;">Saat melakukan pembayaran Harap
                                mencantumkan nomor invoice pada kolom keterangan/berita transfer.</td>
                        </tr>
                        <tr>
                            <td style="width: 25px; vertical-align: top; padding: 0;">5.</td>
                            <td style="vertical-align: top; padding: 0;">NPWP 94.723.616.2-043.000</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; vertical-align: bottom; text-align: center; padding: 0;">
                    <div style="position: relative; display: inline-block;">
                        @if($invoice->show_stamp)
                            <img src="{{ asset('back/assets/images/stampel.png') }}"
                                style="width: 180px; position: absolute; top: -90px; left: 50%; transform: translateX(-50%); z-index: 1;">
                        @endif
                        <div class="font-bold text-center"
                            style="position: relative; z-index: 2; color: #d32f2f; font-size: 11pt; margin-top: 80px; margin-bottom: 2px;">
                        </div>
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