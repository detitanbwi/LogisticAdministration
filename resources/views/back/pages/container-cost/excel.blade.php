<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr>
        <td></td>
    </tr>
    {{-- Row 2: Title --}}
    <tr>
        <td></td>{{-- Col A spacer --}}
        <th colspan="27" align="center" style="font-weight: bold;"><b>CONTAINER COST_LAPORAN PEMBAYARAN</b></th>
    </tr>
    {{-- Row 3: Empty separator --}}
    <tr>
        <td></td>
        <td colspan="27"></td>
    </tr>
    {{-- Row 4: Kapal & Pelabuhan Asal --}}
    <tr>
        <td></td>
        <td colspan="2"><b>Nama Kapal</b></td>
        <td colspan="4">: {{ $container->kapal->nama_kapal ?? '-' }}</td>
        <td colspan="2"><b>Pelabuhan Asal</b></td>
        <td colspan="19">: {{ $container->asal->nama_tujuan ?? '-' }}</td>
    </tr>
    {{-- Row 5: ETD & Pelabuhan Tujuan --}}
    <tr>
        <td></td>
        <td colspan="2"><b>Tgl Keberangkatan (ETD)</b></td>
        <td colspan="4">: {{ $container->etd ? Carbon\Carbon::parse($container->etd)->translatedFormat('d F Y') : '-' }}
        </td>
        <td colspan="2"><b>Pelabuhan Tujuan</b></td>
        <td colspan="19">:
            {{ $container->tujuan->nama_tujuan ?? '-' }}
        </td>
    </tr>
    {{-- Row 6: Contr/Seal & Tipe --}}
    <tr>
        <td></td>
        <td colspan="2"><b>Contr / Seal</b></td>
        <td colspan="4">: {{ $container->nomor_container }}</td>
        <td colspan="2"><b>Tipe Kontainer</b></td>
        <td colspan="19">: {{ $container->tipe_kontainer ?? '-' }}</td>
    </tr>
    {{-- Row 7: Empty separator --}}
    <tr>
        <td></td>
        <td colspan="27"></td>
    </tr>
    {{-- Row 8: Table Header --}}
    <tr>
        <td></td>{{-- Col A spacer --}}
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tgl Masuk</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">HP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jenis Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Koli</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Jumlah</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Sat</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">DPP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Total Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanda Terima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">BAP BALIK</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Daerah Tujuan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Layanan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Di Tagih Ke</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Tagih</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Terima Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status (Tahan/Serahkan)</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">STTS PKP</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Transfer</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Masa Tunggakan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Pembayaran</th>
    </tr>
    {{-- Data Rows --}}
    @php $no = 1; @endphp
    @forelse ($container->invoices as $inv)
        @php
            $rowCount = $inv->items->count() > 0 ? $inv->items->count() : 1;

            $masa_tunggakan = '-';
            if ($inv->finance && $inv->finance->tanggal_tagih) {
                $tgl_tagih = \Carbon\Carbon::parse($inv->finance->tanggal_tagih);
                $tgl_transfer = $inv->finance->tgl_transfer ? \Carbon\Carbon::parse($inv->finance->tgl_transfer) : now();
                $masa_tunggakan = $tgl_tagih->diffInDays($tgl_transfer) . ' Hari';
            }
        @endphp
        <tr>
            <td></td>{{-- Col A spacer --}}
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $no++ }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->no_invoice }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->pengirim->no_hp ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->penerima->no_hp ?? '-' }}</td>

            @if($inv->items->count() > 0)
                <td style="border: 1px solid #000;">{{ $inv->items[0]->jenis_barang }}</td>
                <td style="border: 1px solid #000;">{{ $inv->items[0]->koli }}</td>
                <td style="border: 1px solid #000;">
                    {{ rtrim(rtrim(number_format($inv->items[0]->jumlah, 3, ',', '.'), '0'), ',') }}
                </td>
                <td style="border: 1px solid #000;">{{ $inv->items[0]->satuan }}</td>
            @else
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
                <td style="border: 1px solid #000;">-</td>
            @endif

            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ number_format($inv->dpp ?? 0, 0, ',', '.') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ number_format($inv->grand_total ?? 0, 0, ',', '.') }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->tanda_terima ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->terima_barang ? 'SUDAH' : 'BELUM' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->tujuanDaerah->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->finance && $inv->finance->status_tagihan == 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ strtoupper($inv->layanan ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->finance->ditagih_ke ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->finance && $inv->finance->tanggal_tagih ? $inv->finance->tanggal_tagih->format('d/m/Y') : '-' }}
            </td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->terima_barang ? $inv->terima_barang->format('d/m/Y') : '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->status_pembayaran ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ mb_strtoupper($inv->pkp_status ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">
                {{ $inv->finance && $inv->finance->tgl_transfer ? $inv->finance->tgl_transfer->format('d/m/Y') : '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $masa_tunggakan }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->catatan_muntahan ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}" style="border: 1px solid #000;">{{ $inv->finance->catatan ?? '-' }}</td>
        </tr>
        @if($inv->items->count() > 1)
            @for($i = 1; $i < $rowCount; $i++)
                <tr>
                    <td></td>{{-- Col A spacer --}}
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->jenis_barang }}</td>
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->koli }}</td>
                    <td style="border: 1px solid #000;">
                        {{ rtrim(rtrim(number_format($inv->items[$i]->jumlah, 3, ',', '.'), '0'), ',') }}
                    </td>
                    <td style="border: 1px solid #000;">{{ $inv->items[$i]->satuan }}</td>
                </tr>
            @endfor
        @endif
    @empty
        <tr>
            <td></td>
            <td colspan="27" style="border: 1px solid #000;">Belum ada invoice di dalam container ini.</td>
        </tr>
    @endforelse
    {{-- Empty separator before catatan --}}
    <tr>
        <td></td>
    </tr>
    {{-- Catatan Finance Box --}}
    <tr>
        <td></td>
        <td colspan="4" style="border: 1px solid #000; font-weight: bold;">Catatan Finance:</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4" style="border: 1px solid #000; vertical-align: top;">{{ $container->catatan_finance ?? '-' }}
        </td>
    </tr>
</table>