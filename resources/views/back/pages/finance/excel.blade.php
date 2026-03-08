<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr style="vertical-align: middle;">
        <td></td>
    </tr>
    {{-- Row 2: Title --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="9" align="center" style="font-weight: bold; font-size: 14pt;">
            {{ $filters['judul_print'] ?? 'Rekapitulasi Finance' }}
        </th>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="9" align="center" style="font-weight: bold; font-size: 12pt;">PT. SINAR CEMARA JAYA</th>
    </tr>
    {{-- Row 3: Empty separator --}}
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="9"></td>
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
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanggal Tagih</th>
        <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Masa Tunggakan</th>
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
                    {{ $data->invoice ? $data->invoice->no_invoice : '-' }}</td>
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
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->tanggal_tagih ? \Carbon\Carbon::parse($data->tanggal_tagih)->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $masaText }}</td>
            </tr>
            @if($rowspan > 1)
                @for($i = 1; $i < $rowspan; $i++)
                    <tr style="vertical-align: middle;">
                        <td></td>{{-- Col A spacer --}}
                        <td style="border: 1px solid #000;">{{ $fees[$i]->nama }} -
                            {{ number_format($fees[$i]->harga, 0, ',', '.') }}</td>
                    </tr>
                @endfor
            @endif
        @endforeach
    </tbody>
</table>