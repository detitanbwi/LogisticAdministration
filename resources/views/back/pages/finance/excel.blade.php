<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr style="vertical-align: middle;">
        <td></td>
    </tr>
    {{-- Row 2: Title --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="42" align="center" style="font-weight: bold; font-size: 14pt;">
            {{ $filters['judul_print'] ? $filters['judul_print'] : 'REKAPITULASI FINANCE' }}
        </th>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>
        <th colspan="42" align="center" style="font-weight: bold; font-size: 11pt;">
            Periode: {{ !empty($filters['daterange']) ? $filters['daterange'] : 'Semua tanggal' }}
        </th>
    </tr>
    {{-- Row 3: Empty separator --}}
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="42"></td>
    </tr>
    {{-- Row 4: Table Header --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tgl Masuk</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Contr / Seal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tipe Kontainer</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Metode</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Nama Kapal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">ETD</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pelabuhan Asal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pelabuhan Tujuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">ETA</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Alamat Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">NPWP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Alamat Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">NPWP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jenis Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Koli</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jumlah</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Sat</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Harga Satuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Subtotal</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">DPP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Biaya Tambahan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Total Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanda Terima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">BAP BALIK</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Daerah Tujuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Terima Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Layanan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Di Tagih Ke</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Tagih</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Masa Tunggakan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status (Tahan/Serahkan)</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">STTS PKP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Transfer</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Invoice - Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Pembayaran</th>
    </tr>
    {{-- Data Rows --}}
    @php 
        $no = 1; 
        $grandTotalJumlah = 0;
    @endphp
    @forelse ($finances as $finance)
        @php
            $inv = $finance->invoice;

            if (!$inv) {
                continue; // Skip if no invoice is associated somehow
            }

            $rowCount = $inv->items && $inv->items->count() > 0 ? $inv->items->count() : 1;

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
            $dpp_display = $dpp_base;
            $grand_total_val = $dpp_and_fee_val + $ppn_val;

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
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $no++ }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->no_invoice }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->container->nomor_container ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->container->tipe_kontainer ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->metode ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->container->kapal->nama_kapal ?? '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->container && $inv->container->etd ? $inv->container->etd->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->container->asal->nama_tujuan ?? '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->container->tujuan->nama_tujuan ?? '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->container && $inv->container->eta ? $inv->container->eta->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->no_hp ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->alamat ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->npwp ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->no_hp ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->alamat ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->npwp ?? '-' }}</td>

            @if($inv->items && $inv->items->count() > 0)
                <td style="border: 1px solid #000;">{{ $inv->items[0]->jenis_barang }}</td>
                <td style="border: 1px solid #000;">{{ $inv->items[0]->koli }}</td>
                <td style="border: 1px solid #000;">
                    {{ rtrim(rtrim(number_format($inv->items[0]->jumlah, 3, ',', '.'), '0'), ',') }}
                </td>
                <td style="border: 1px solid #000;">{{ $inv->items[0]->satuan }}</td>
                <td style="border: 1px solid #000;">
                    {{ number_format($inv->items[0]->harga_satuan, 0, '', '') }}
                </td>
                <td style="border: 1px solid #000;">
                    @php
                        $sub = (strtoupper($inv->items[0]->satuan) == 'UNIT') 
                            ? $inv->items[0]->koli * $inv->items[0]->harga_satuan 
                            : $inv->items[0]->jumlah * $inv->items[0]->harga_satuan;
                    @endphp
                    {{ number_format($sub, 0, '', '') }}
                </td>
            @else
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">0</td>
                <td style="border: 1px solid #000;">0</td>
            @endif

            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ number_format($dpp_display, 0, '', '') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                @if($inv->additionalFees && $inv->additionalFees->count() > 0)
                    {{ number_format($inv->additionalFees->sum('harga'), 0, '', '') }}
                    ({{ $inv->additionalFees->pluck('nama')->implode(', ') }})
                @else
                    -
                @endif
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ number_format(round($grand_total_val), 0, '', '') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->tanda_terima ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $finance->bap_balik ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->tujuanDaerah->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->terima_barang ? $inv->terima_barang->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ strtoupper($finance->status_tagihan ?? '-') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->layanan ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $finance->ditagih_ke ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $finance->tanggal_tagih ? \Carbon\Carbon::parse($finance->tanggal_tagih)->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $masaText }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->status_pembayaran ?? '-') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ mb_strtoupper($inv->pkp_status ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $finance->tgl_transfer ? \Carbon\Carbon::parse($finance->tgl_transfer)->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->catatan_muntahan ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $finance->catatan ?? '-' }}</td>
        </tr>
        @if($inv->items && $inv->items->count() > 1)
            @for($i = 1; $i < $rowCount; $i++)
                <tr style="vertical-align: middle;">
                    <td></td>{{-- Col A spacer --}}
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->jenis_barang }}</td>
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->koli }}</td>
                    <td style="border: 1px solid #000;">
                        {{ rtrim(rtrim(number_format($inv->items[$i]->jumlah, 3, ',', '.'), '0'), ',') }}
                    </td>
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->satuan }}</td>
                    <td style="border: 1px solid #000;">
                        {{ number_format($inv->items[$i]->harga_satuan, 0, '', '') }}
                    </td>
                    <td style="border: 1px solid #000;">
                        @php
                            $subItem = (strtoupper($inv->items[$i]->satuan) == 'UNIT') 
                                ? $inv->items[$i]->koli * $inv->items[$i]->harga_satuan 
                                : $inv->items[$i]->subtotal;
                        @endphp
                        {{ number_format($subItem, 0, '', '') }}
                    </td>
                </tr>
            @endfor
        @endif
    @empty
        <tr style="vertical-align: middle;">
            <td></td>
            <td colspan="42" style="border: 1px solid #000;" align="center">Belum ada tagihan.</td>
        </tr>
    @endforelse
    {{-- Total Accumulation Row --}}
    <tr style="vertical-align: middle; font-weight: bold; background-color: #f2f2f2;">
        <td></td>{{-- Col A spacer --}}
        <td colspan="21" style="border: 1px solid #000;" align="right">TOTAL JUMLAH</td>
        <td style="border: 1px solid #000;" align="center">{{ number_format($grandTotalJumlah, 3, ',', '.') }}</td>
        <td colspan="20" style="border: 1px solid #000;"></td>
    </tr>
    <tr style="vertical-align: middle; font-weight: bold; background-color: #e2e2e2;">
        <td></td>{{-- Col A spacer --}}
        <td colspan="25" style="border: 1px solid #000;" align="right">GRAND TOTAL</td>
        <td style="border: 1px solid #000;" align="center">{{ number_format($grandTotalTagihan, 0, ',', '.') }}</td>
        <td colspan="16" style="border: 1px solid #000;"></td>
    </tr>
</table>