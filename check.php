<?php

$finances = \App\Models\Finance::whereNotNull('tgl_transfer')->where('total_tagihan', '>', 0)->get();
$rekening = \App\Models\BankRekening::first();

echo "Rekening Count: " . \App\Models\BankRekening::count() . "\n";
echo "Finance Count: " . $finances->count() . "\n";

foreach ($finances as $f) {
    echo "Finance ID: {$f->id}, Tgl: {$f->tgl_transfer}, Total: {$f->total_tagihan}\n";
}
