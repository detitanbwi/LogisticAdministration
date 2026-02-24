<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - SCJ Finance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        table.info {
            width: 50%;
            margin-bottom: 20px;
            font-size: 12px;
        }

        table.info th {
            text-align: left;
            width: 150px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.data th,
        table.data td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        table.data th {
            background-color: #f5f5f5;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .fw-bold {
            font-weight: bold;
        }

        .bg-primary {
            background-color: #0d6efd;
            color: #fff;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .font-monospace {
            font-family: monospace;
        }

        @media print {
            body {
                padding: 0;
            }

            .bg-primary {
                background-color: #0d6efd !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .bg-light {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .text-success {
                color: #28a745 !important;
            }

            .text-danger {
                color: #dc3545 !important;
            }
        }
    </style>
</head>

<body>

    <h2>LAPORAN PEMASUKAN & PENGELUARAN</h2>
    <h3>SCJ Finance</h3>

    <table class="info">
        <tr>
            <th>DARI TANGGAL</th>
            <td>: {{ $tanggal_dari }}</td>
        </tr>
        <tr>
            <th>SAMPAI TANGGAL</th>
            <td>: {{ $tanggal_sampai }}</td>
        </tr>
        <tr>
            <th>KATEGORI</th>
            <td>: {{ $detailKategori }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th rowspan="2" style="width: 5%">NO</th>
                <th rowspan="2">TANGGAL</th>
                <th rowspan="2">KATEGORI</th>
                <th rowspan="2">KETERANGAN</th>
                <th colspan="2">JENIS</th>
            </tr>
            <tr>
                <th>PEMASUKAN</th>
                <th>PENGELUARAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalPengeluaran = 0;
            @endphp
            @forelse ($transaksis as $index => $row)
                @php
                    if (strtolower($row->jenis) === 'pemasukan') {
                        $totalPemasukan += $row->nominal;
                    } else {
                        $totalPengeluaran += $row->nominal;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('Y/m/d') }}</td>
                    <td>{{ $row->kategori->nama ?? '-' }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                    <td class="text-end text-success font-monospace">
                        {{ strtolower($row->jenis) === 'pemasukan' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') . ',-' : '-' }}
                    </td>
                    <td class="text-end text-danger font-monospace">
                        {{ strtolower($row->jenis) !== 'pemasukan' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') . ',-' : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada catatan transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold bg-light">
                <td colspan="4" class="text-end">TOTAL</td>
                <td class="text-end text-success font-monospace">Rp {{ number_format($totalPemasukan, 0, ',', '.') }},-
                </td>
                <td class="text-end text-danger font-monospace">Rp
                    {{ number_format($totalPengeluaran, 0, ',', '.') }},-</td>
            </tr>
            <tr class="fw-bold bg-primary text-white">
                <td colspan="4" class="text-end" style="color:#fff;">SALDO</td>
                @php
                    $saldo = $totalPemasukan - $totalPengeluaran;
                @endphp
                <td colspan="2" class="text-center font-monospace" style="color:#fff;">
                    Rp {{ number_format($saldo, 0, ',', '.') }},-
                </td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
