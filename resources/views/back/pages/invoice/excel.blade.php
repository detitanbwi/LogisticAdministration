<table>
    {{-- Row 1: Empty row for top spacing --}}
    <tr style="vertical-align: middle;">
        <td></td>
    </tr>
    {{-- Row 2: Title --}}
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="8" align="center" style="font-weight: bold; font-size: 14pt;">
            {{ $filters['judul_print'] ?? 'Rekapitulasi Invoice' }}
        </th>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
        <th colspan="8" align="center" style="font-weight: bold; font-size: 12pt;">PT. SINAR CEMARA JAYA</th>
    </tr>
    {{-- Row 3: Empty separator --}}
    <tr style="vertical-align: middle;">
        <td></td>
        <td colspan="8"></td>
    </tr>
    <tr style="vertical-align: middle;">
        <td></td>{{-- Col A spacer --}}
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">No Invoice</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">ETD</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Pengirim</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Penerima</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Biaya Tambahan</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tagihan</th>
            <th style="font-weight: bold; background-color: #fce4d6; border: 1px solid #000;">Tanda Terima</th>
    </tr>
    <tbody>
        @foreach($invoices as $index => $data)
            @php
                $fees = $data->additionalFees ? $data->additionalFees : collect();
                $rowspan = $fees->count() > 0 ? $fees->count() : 1;
            @endphp
            <tr style="vertical-align: middle;">
                <td></td>{{-- Col A spacer --}}
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $index + 1 }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->no_invoice }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->container && $data->container->etd ? $data->container->etd->format('d-m-Y') : '-' }}
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->pengirim ? $data->pengirim->nama : '-' }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->penerima ? $data->penerima->nama : '-' }}</td>
                <td style="border: 1px solid #000;">
                    @if($fees->count() > 0)
                        {{ $fees[0]->nama }} - {{ number_format($fees[0]->harga, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">
                    {{ $data->finance ? $data->finance->total_tagihan : 0 }}</td>
                <td rowspan="{{ $rowspan }}" style="border: 1px solid #000;">{{ $data->tanda_terima ?? '-' }}</td>
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