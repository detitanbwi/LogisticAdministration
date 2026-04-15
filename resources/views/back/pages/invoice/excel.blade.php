<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr style="vertical-align: middle;">
        <td></td>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="29" align="center" style="font-weight: bold; font-size: 14pt;">
            {{ $filters['judul_print'] ?? 'REKAPITULASI INVOICE' }}
        </th>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>
        <th colspan="29" align="center" style="font-weight: bold; font-size: 11pt;">
            Periode: {{ !empty($filters['daterange']) ? $filters['daterange'] : 'Semua tanggal' }}
        </th>
    </tr>
    {{-- Row 3: Empty separator --}}
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="29"></td>
    </tr>
    {{-- Row 4: Table Header --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tgl Masuk</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Alamat Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">NPWP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Alamat Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">NPWP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Up</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Kapal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pelabuhan Asal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pelabuhan Tujuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Daerah Tujuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">ETD</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">ETA</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tipe Kontainer</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Contr / Seal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Layanan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jenis Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Koli</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jumlah</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Sat</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">DPP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Biaya Tambahan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Total Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">STTS PKP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanda Terima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Invoice - Barang</th>
    </tr>
    <tbody>
        @php 
            $grandTotalJumlah = 0;
            $grandTotalTagihan = 0;
        @endphp
        @foreach($invoices as $index => $inv)
            @php
                $rowCount = $inv->items && $inv->items->count() > 0 ? $inv->items->count() : 1;
                $dpp_base = $inv->items ? $inv->items->sum(function($item) {
                    return $item->jumlah * $item->harga_satuan;
                }) : 0;
                $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
                $dpp_and_fee_val = $dpp_base + $fee_val;
                $is_pkp = strtoupper($inv->pkp_status) == 'PKP';
                $ppn_val = $is_pkp ? $dpp_and_fee_val * 0.011 : 0;
                $dpp_display = $dpp_base;
                $grand_total_val = $dpp_and_fee_val + $ppn_val;
                $grandTotalTagihan += $grand_total_val;

                if ($inv->items) {
                    foreach($inv->items as $item) {
                        if (strtolower($item->satuan) != 'unit') {
                            $grandTotalJumlah += $item->jumlah;
                        }
                    }
                }
            @endphp
            <tr style="vertical-align: middle;">
                <td></td>{{-- Col A spacer --}}
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->no_invoice }}</td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->pengirim ? $inv->pengirim->nama : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->pengirim ? $inv->pengirim->no_hp : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->pengirim ? $inv->pengirim->alamat : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->pengirim ? $inv->pengirim->npwp : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->penerima ? $inv->penerima->nama : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->penerima ? $inv->penerima->no_hp : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->penerima ? $inv->penerima->alamat : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->penerima ? $inv->penerima->npwp : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->upDetail ? $inv->upDetail->nama : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container && $inv->container->kapal ? $inv->container->kapal->nama_kapal : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container && $inv->container->asal ? $inv->container->asal->nama_tujuan : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container && $inv->container->tujuan ? $inv->container->tujuan->nama_tujuan : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->tujuanDaerah ? $inv->tujuanDaerah->nama : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container && $inv->container->etd ? \Carbon\Carbon::parse($inv->container->etd)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container && $inv->container->eta ? \Carbon\Carbon::parse($inv->container->eta)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container ? $inv->container->tipe_kontainer : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ $inv->container ? $inv->container->nomor_container : '-' }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                    {{ strtoupper($inv->layanan ?? '-') }}
                </td>

                @if($inv->items && $inv->items->count() > 0)
                    <td style="border: 1px solid #000;">{{ $inv->items[0]->jenis_barang }}</td>
                    <td style="border: 1px solid #000;">{{ $inv->items[0]->koli }}</td>
                    <td style="border: 1px solid #000;">
                        {{ number_format($inv->items[0]->jumlah, 3, ',', '.') }}
                    </td>
                    <td style="border: 1px solid #000;">{{ $inv->items[0]->satuan }}</td>
                @else
                    <td style="border: 1px solid #000;">-</td>
                    <td style="border: 1px solid #000;">-</td>
                    <td style="border: 1px solid #000;">-</td>
                    <td style="border: 1px solid #000;">-</td>
                @endif

                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000; mso-number-format:'\@';" data-type="string">
                    {{ number_format($dpp_display, 0, ',', '.') }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000; mso-number-format:'\@';" data-type="string">
                    @if($inv->additionalFees && $inv->additionalFees->count() > 0)
                        {{ number_format($inv->additionalFees->sum('harga'), 0, ',', '.') }}
                        ({{ $inv->additionalFees->pluck('nama')->implode(', ') }})
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000; mso-number-format:'\@';" data-type="string">
                    {{ number_format(round($grand_total_val), 0, ',', '.') }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ mb_strtoupper($inv->pkp_status ?? '-') }}
                </td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->tanda_terima ?? '-' }}</td>
                <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->catatan_muntahan ?? '-' }}</td>
            </tr>
            @if($rowCount > 1)
                @for($i = 1; $i < $rowCount; $i++)
                    <tr style="vertical-align: middle;">
                        <td></td>{{-- Col A spacer --}}
                        <td style="border: 1px solid #000;">{{ $inv->items[$i]->jenis_barang }}</td>
                        <td style="border: 1px solid #000;">{{ $inv->items[$i]->koli }}</td>
                        <td style="border: 1px solid #000;">
                            {{ number_format($inv->items[$i]->jumlah, 3, ',', '.') }}
                        </td>
                        <td style="border: 1px solid #000;">{{ $inv->items[$i]->satuan }}</td>
                    </tr>
                @endfor
            @endif
        @endforeach
        {{-- Total Accumulation Row --}}
        <tr style="vertical-align: middle; font-weight: bold; background-color: #f2f2f2;">
            <td></td>{{-- Col A spacer --}}
            <td colspan="23" style="border: 1px solid #000;" align="right">TOTAL JUMLAH</td>
            <td style="border: 1px solid #000;" align="center">{{ number_format($grandTotalJumlah, 3, ',', '.') }}</td>
            <td colspan="7" style="border: 1px solid #000;"></td>
        </tr>
        <tr style="vertical-align: middle; font-weight: bold; background-color: #e2e2e2;">
            <td></td>{{-- Col A spacer --}}
            <td colspan="27" style="border: 1px solid #000;" align="right">GRAND TOTAL</td>
            <td style="border: 1px solid #000;" align="center">{{ number_format($grandTotalTagihan, 0, ',', '.') }}</td>
            <td colspan="3" style="border: 1px solid #000;"></td>
        </tr>
    </tbody>
</table>