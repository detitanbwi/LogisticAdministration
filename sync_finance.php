<?php

$finances = \App\Models\Finance::whereNotNull('tgl_transfer')->where('total_tagihan', '>', 0)->get();
$rekening = \App\Models\BankRekening::first();
$kategori = \App\Models\TransaksiKategori::firstOrCreate(
    ['nama' => 'Pemasukan Invoice'],
    ['jenis' => 'pemasukan']
);

$count = 0;
if ($rekening) {
    foreach ($finances as $finance) {
        $finance->load('invoice');
        if (!$finance->invoice)
            continue;

        $keterangan = 'Pembayaran Invoice ' . $finance->invoice->no_invoice;
        $existing = \App\Models\Transaksi::where('keterangan', $keterangan)->first();
        if (!$existing) {
            \App\Models\Transaksi::create([
                'tanggal' => $finance->tgl_transfer,
                'jenis' => 'pemasukan',
                'transaksi_kategori_id' => $kategori->id,
                'nominal' => $finance->total_tagihan,
                'keterangan' => $keterangan,
                'bank_rekening_id' => $rekening->id
            ]);
            $rekening->saldo += $finance->total_tagihan;
            $rekening->save();
            $count++;
        }
    }
}
echo "Done importing $count old finance records.\n";
