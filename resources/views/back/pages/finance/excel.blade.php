<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr style="vertical-align: middle;">
        <td></td>
    </tr>
    {{-- Row 2: Title --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="17" align="center" style="font-weight: bold; font-size: 14pt;">
            {{ $filters['judul_print'] ? $filters['judul_print'] : 'REKAPITULASI' }}
        </th>
    </tr>
    {{-- Row 2: Empty separator --}}
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="17"></td>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No Invoice</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pengirim</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Penerima</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Biaya Tambahan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Total Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status Tagihan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Ditagih Ke</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Tagih</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Masa Tunggakan</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">BAP Balik</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Status Pembayaran</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Terima Barang</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Transfer</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Bank / Rekening</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Catatan Finance</th>
    </tr>
    <tbody>
        @foreach($finances as $index => $data)
            @php
                $statusText = $data->status_tagihan;
                if ($data->tgl_transfer) {
                    $masaText = 'Lunas';
                } else {
                    $masaText = '-';
                    if ($data->tanggal_tagih) {
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $tagih = \Carbon\Carbon::parse($data->tanggal_tagih)->startOfDay();
                        $diffDays = $tagih->diffInDays($today, false);
                        if ($diffDays > 0) {
                            $masaText = intval($diffDays) . ' Hari';
                        }
                    }
                }
                $fees = $data->invoice && $data->invoice->additionalFees ? $data->invoice->additionalFees : collect();
                $rowspan = $fees->count() > 0 ? $fees->count() : 1;
            @endphp
            <tr style="vertical-align: middle;">
                <td></td>{{-- Col A spacer --}}
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->invoice ? $data->invoice->no_invoice : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->invoice && $data->invoice->pengirim ? $data->invoice->pengirim->nama : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->invoice && $data->invoice->penerima ? $data->invoice->penerima->nama : '-' }}
                </td>
                <td style="border: 1px solid #000;">
                    @if($fees->count() > 0)
                        {{ $fees[0]->nama }} - {{ number_format($fees[0]->harga, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->total_tagihan }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $statusText }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->ditagih_ke }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->tanggal_tagih ? \Carbon\Carbon::parse($data->tanggal_tagih)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $masaText }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->bap_balik }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->invoice ? $data->invoice->status_pembayaran : '-' }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->invoice && $data->invoice->terima_barang ? \Carbon\Carbon::parse($data->invoice->terima_barang)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->tgl_transfer ? \Carbon\Carbon::parse($data->tgl_transfer)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->bankRekening ? $data->bankRekening->nama_bank . ' - ' . $data->bankRekening->nomor_rekening : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->catatan }}</td>
            </tr>
            @if($rowspan > 1)
                @for($i = 1; $i < $rowspan; $i++)
                    <tr style="vertical-align: middle;">
                        <td></td>{{-- Col A spacer --}}
                        <td style="border: 1px solid #000;">{{ $fees[$i]->nama }} -
                            {{ number_format($fees[$i]->harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @endfor
            @endif
        @endforeach
    </tbody>
</table>