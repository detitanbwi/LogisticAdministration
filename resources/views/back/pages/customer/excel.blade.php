<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No HP</th>
        <th>NPWP</th>
        <th>PIC</th>
        <th>Jabatan PIC</th>
        <th>Alamat</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $index => $customer)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->no_hp }}</td>
            <td>{{ $customer->npwp }}</td>
            <td>{{ $customer->pic }}</td>
            <td>{{ $customer->jabatan_pic }}</td>
            <td>{{ $customer->alamat }}</td>
            <td>{{ $customer->catatan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
