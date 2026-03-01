<table>
    <tr>
        <th colspan="15" align="center"><b>MANIFEST CONTAINER_PACKING LIST</b></th>
    </tr>
    <tr>
        <td colspan="15"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Nama Kapal</b></td>
        <td colspan="4">: {{ $container->kapal->nama_kapal ?? '-' }}</td>
        <td colspan="2"><b>Lokasi Asal</b></td>
        <td colspan="7">: {{ $container->asal->nama_tujuan ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Tgl Keberangkatan (ETD)</b></td>
        <td colspan="4">: {{ $container->etd ? Carbon\Carbon::parse($container->etd)->translatedFormat('d F Y') : '-' }}
        </td>
        <td colspan="2"><b>Lokasi Tujuan</b></td>
        <td colspan="7">:
            {{ $container->tujuan->nama_tujuan ?? '-' }}{{ $container->tujuanDaerah ? ' - ' . $container->tujuanDaerah->nama : '' }}
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Contr / Seal</b></td>
        <td colspan="4">: {{ $container->nomor_container }}</td>
        <td colspan="2"><b>Tipe Kontainer</b></td>
        <td colspan="7">: {{ $container->tipe_kontainer ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="15"></td>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #fce4d6;">No</th>
        <th style="font-weight: bold; background-color: #fce4d6;">No Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Tgl Masuk</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6;">HP Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6;">HP Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Jenis Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Koli</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Jumlah</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Sat</th>
        <th style="font-weight: bold; background-color: #fce4d6;">BAP BALIK</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Status</th>
        <th style="font-weight: bold; background-color: #fce4d6;">Layanan</th>
        <th style="font-weight: bold; background-color: #fce4d6;">STTS PKP</th>
    </tr>
    @php $no = 1; @endphp
    @forelse ($container->invoices as $inv)
        @php
            $rowCount = $inv->items->count() > 0 ? $inv->items->count() : 1;
        @endphp
        <tr>
            <td rowspan="{{ $rowCount }}">{{ $no++ }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->no_invoice }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->tgl_masuk ? $inv->tgl_masuk->format('d/m/Y') : '-' }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->pengirim->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->pengirim->no_hp ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->penerima->nama ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->penerima->no_hp ?? '-' }}</td>

            @if($inv->items->count() > 0)
                <td>{{ $inv->items[0]->jenis_barang }}</td>
                <td>{{ $inv->items[0]->koli }}</td>
                <td>{{ rtrim(rtrim(number_format($inv->items[0]->jumlah, 3, ',', '.'), '0'), ',') }}</td>
                <td>{{ $inv->items[0]->satuan }}</td>
            @else
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            @endif

            <td rowspan="{{ $rowCount }}">{{ $inv->terima_barang ? 'SUDAH' : 'BELUM' }}</td>
            <td rowspan="{{ $rowCount }}">{{ $inv->status_pembayaran ?? '-' }}</td>
            <td rowspan="{{ $rowCount }}">{{ strtoupper($inv->layanan ?? '-') }}</td>
            <td rowspan="{{ $rowCount }}">{{ mb_strtoupper($inv->pkp_status) }}</td>
        </tr>
        @if($inv->items->count() > 1)
            @for($i = 1; $i < $rowCount; $i++)
                <tr>
                    <td>{{ $inv->items[$i]->jenis_barang }}</td>
                    <td>{{ $inv->items[$i]->koli }}</td>
                    <td>{{ rtrim(rtrim(number_format($inv->items[$i]->jumlah, 3, ',', '.'), '0'), ',') }}</td>
                    <td>{{ $inv->items[$i]->satuan }}</td>
                </tr>
            @endfor
        @endif
    @empty
        <tr>
            <td colspan="15">Belum ada invoice di dalam container ini.</td>
        </tr>
    @endforelse
</table>