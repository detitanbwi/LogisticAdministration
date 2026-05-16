<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Finance;
use App\Models\JudulPrint;

class ExportController extends Controller
{
    public function init(Request $request)
    {
        $type = $request->type;
        $taskId = Str::uuid()->toString();
        
        $query = $this->getQuery($type, $request);
        $total = $query->count();
        
        if ($total == 0) {
            return response()->json(['error' => 'Tidak ada data untuk dieksport pada range tanggal ini.'], 422);
        }

        // Initialize temporary storage
        if (!Storage::exists('temp_exports')) {
            Storage::makeDirectory('temp_exports');
        }
        
        Storage::put("temp_exports/{$taskId}.json", json_encode([]));

        // Store filters and state in Cache
        Cache::put("export_{$taskId}", [
            'type' => $type,
            'filters' => $request->all(),
            'total' => $total,
            'processed' => 0,
            'cancelled' => false,
            'ids' => $query->pluck('id')->toArray(),
            'grand_total_jumlah' => 0,
            'grand_total_tagihan' => 0,
            'row_index' => 1
        ], now()->addHours(2));

        return response()->json([
            'task_id' => $taskId,
            'total' => $total
        ]);
    }

    public function process(Request $request)
    {
        $taskId = $request->task_id;
        $state = Cache::get("export_{$taskId}");

        if (!$state) {
            return response()->json(['error' => 'Task tidak ditemukan atau sudah kadaluarsa.'], 404);
        }

        if ($state['cancelled']) {
            return response()->json(['cancelled' => true]);
        }

        $chunkSize = 25; // Balanced chunk
        $processed = $state['processed'];
        $total = $state['total'];
        $ids = array_slice($state['ids'], $processed, $chunkSize);
        
        $rows = [];
        if ($state['type'] == 'invoice') {
            $items = Invoice::with(['container.kapal', 'container.tujuan', 'container.asal', 'pengirim', 'penerima', 'finance', 'additionalFees', 'tujuanDaerah', 'items', 'upDetail', 'layanan'])
                ->whereIn('id', $ids)
                ->get();

            foreach ($items as $inv) {
                $itemRows = $this->formatInvoiceRows($inv, $state);
                foreach ($itemRows as $row) {
                    $rows[] = $row;
                }
            }
        } else {
            $items = Finance::with(['invoice.pengirim', 'invoice.penerima', 'invoice.items', 'invoice.container.kapal', 'invoice.container.asal', 'invoice.container.tujuan', 'invoice.additionalFees', 'invoice.tujuanDaerah'])
                ->whereIn('id', $ids)
                ->get();

            foreach ($items as $fin) {
                $itemRows = $this->formatFinanceRows($fin, $state);
                foreach ($itemRows as $row) {
                    $rows[] = $row;
                }
            }
        }

        // Append to JSON file
        $currentData = json_decode(Storage::get("temp_exports/{$taskId}.json"), true);
        $mergedData = array_merge($currentData, $rows);
        Storage::put("temp_exports/{$taskId}.json", json_encode($mergedData));

        $nextProcessed = min($processed + $chunkSize, $total);
        $state['processed'] = $nextProcessed;
        
        Cache::put("export_{$taskId}", $state, now()->addHours(2));

        return response()->json([
            'processed' => $nextProcessed,
            'total' => $total,
            'done' => $nextProcessed >= $total
        ]);
    }

    public function cancel(Request $request)
    {
        $taskId = $request->task_id;
        $state = Cache::get("export_{$taskId}");
        
        if ($state) {
            $state['cancelled'] = true;
            Cache::put("export_{$taskId}", $state, now()->addHours(2));
        }

        return response()->json(['success' => true]);
    }

    public function download(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        $taskId = $request->task_id;
        $state = Cache::get("export_{$taskId}");

        if (!$state || !Storage::exists("temp_exports/{$taskId}.json")) {
            return abort(404, 'Task not found or data expired');
        }

        $data = json_decode(Storage::get("temp_exports/{$taskId}.json"), true);
        
        if ($state['type'] == 'invoice') {
            $sumRow1 = array_fill(0, 32, '');
            $sumRow1[23] = 'TOTAL JUMLAH';
            $sumRow1[24] = number_format($state['grand_total_jumlah'], 3, ',', '.');
            $data[] = $sumRow1;

            $sumRow2 = array_fill(0, 32, '');
            $sumRow2[27] = 'GRAND TOTAL';
            $sumRow2[28] = number_format($state['grand_total_tagihan'], 0, ',', '.');
            $data[] = $sumRow2;
            
            $headings = ['', 'No', 'No Invoice', 'Tgl Masuk', 'Pengirim', 'HP Pengirim', 'Alamat Pengirim', 'NPWP Pengirim', 'Penerima', 'HP Penerima', 'Alamat Penerima', 'NPWP Penerima', 'Up', 'Kapal', 'Pelabuhan Asal', 'Pelabuhan Tujuan', 'Daerah Tujuan', 'ETD', 'ETA', 'Tipe Kontainer', 'Contr / Seal', 'Layanan', 'Jenis Barang', 'Koli', 'Jumlah', 'Sat', 'DPP', 'Biaya Tambahan', 'Total Tagihan', 'STTS PKP', 'Tanda Terima', 'Catatan'];
            $title = $state['filters']['judul_print'] ?? 'REKAPITULASI INVOICE';
        } else {
            $sumRow1 = array_fill(0, 43, '');
            $sumRow1[21] = 'TOTAL JUMLAH';
            $sumRow1[22] = number_format($state['grand_total_jumlah'], 3, ',', '.');
            $data[] = $sumRow1;

            $sumRow2 = array_fill(0, 43, '');
            $sumRow2[25] = 'GRAND TOTAL';
            $sumRow2[26] = number_format($state['grand_total_tagihan'], 0, ',', '.');
            $data[] = $sumRow2;

            $headings = ['', 'No', 'No Invoice', 'Tgl Masuk', 'Contr / Seal', 'Tipe Kontainer', 'Metode', 'Nama Kapal', 'ETD', 'Pelabuhan Asal', 'Pelabuhan Tujuan', 'ETA', 'Pengirim', 'HP Pengirim', 'Alamat Pengirim', 'NPWP Pengirim', 'Penerima', 'HP Penerima', 'Alamat Penerima', 'NPWP Penerima', 'Jenis Barang', 'Koli', 'Jumlah', 'Sat', 'Harga Satuan', 'Subtotal', 'DPP', 'Biaya Tambahan', 'Total Tagihan', 'Tanda Terima', 'BAP BALIK', 'Daerah Tujuan', 'Tgl Terima Barang', 'Status Tagihan', 'Layanan', 'Di Tagih Ke', 'Tanggal Tagih', 'Masa Tunggakan', 'Status (Tahan/Serahkan)', 'STTS PKP', 'Tanggal Transfer', 'Catatan Invoice', 'Catatan Pembayaran'];
            $title = $state['filters']['judul_print'] ?? 'REKAPITULASI FINANCE';
        }

        $finalData = [];
        $colCount = count($headings);
        
        $finalData[] = array_pad(['', $title], $colCount, '');
        $finalData[] = array_pad(['', 'Periode: ' . ($state['filters']['daterange'] ?? 'Semua Tanggal')], $colCount, '');
        $finalData[] = array_pad([''], $colCount, ''); // Spacer
        $finalData[] = $headings;

        foreach ($data as $row) {
            $finalData[] = $row;
        }

        $export = new \App\Exports\GenericArrayExport($finalData, [], $title, $state['filters']);

        // Clean up
        Storage::delete("temp_exports/{$taskId}.json");
        Cache::forget("export_{$taskId}");

        return \Maatwebsite\Excel\Facades\Excel::download($export, ($state['type'] == 'invoice' ? 'Invoice' : 'Finance') . 'Rekap_' . date('YmdHis') . '.xlsx');
    }

    protected function formatInvoiceRows($inv, &$state)
    {
        $rows = [];
        $items = $inv->items;
        $rowCount = count($items) > 0 ? count($items) : 1;
        
        $dpp_base = $items->sum(function($item) {
            return $item->jumlah * $item->harga_satuan;
        });
        $fee_val = $inv->additionalFees ? $inv->additionalFees->sum('harga') : 0;
        $dpp_and_fee_val = $dpp_base + $fee_val;
        $is_pkp = strtoupper($inv->pkp_status) == 'PKP';
        $ppn_val = $is_pkp ? $dpp_and_fee_val * 0.011 : 0;
        $grand_total_val = $dpp_and_fee_val + $ppn_val;

        $state['grand_total_tagihan'] += $grand_total_val;

        for ($i = 0; $i < $rowCount; $i++) {
            $item = $items[$i] ?? null;
            if ($item && strtolower($item->satuan) != 'unit') {
                $state['grand_total_jumlah'] += $item->jumlah;
            }

            $row = [
                '', // Spacer Col A
                $i == 0 ? $state['row_index'] : '',
                $i == 0 ? $inv->no_invoice : '',
                $i == 0 ? ($inv->tgl_masuk ? $inv->tgl_masuk->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->pengirim ? $inv->pengirim->nama : '-') : '',
                $i == 0 ? ($inv->pengirim ? $inv->pengirim->no_hp : '-') : '',
                $i == 0 ? ($inv->pengirim ? $inv->pengirim->alamat : '-') : '',
                $i == 0 ? ($inv->pengirim && $inv->pengirim->npwp ? $inv->pengirim->npwp : '-') : '-',
                $i == 0 ? ($inv->penerima ? $inv->penerima->nama : '-') : '-',
                $i == 0 ? ($inv->penerima ? $inv->penerima->no_hp : '-') : '-',
                $i == 0 ? ($inv->penerima ? $inv->penerima->alamat : '-') : '-',
                $i == 0 ? ($inv->penerima && $inv->penerima->npwp ? $inv->penerima->npwp : '-') : '-',
                $i == 0 ? ($inv->upDetail ? $inv->upDetail->nama : '-') : '',
                $i == 0 ? ($inv->container && $inv->container->kapal ? $inv->container->kapal->nama_kapal : '-') : '',
                $i == 0 ? ($inv->container && $inv->container->asal ? $inv->container->asal->nama_tujuan : '-') : '',
                $i == 0 ? ($inv->container && $inv->container->tujuan ? $inv->container->tujuan->nama_tujuan : '-') : '',
                $i == 0 ? ($inv->tujuanDaerah ? $inv->tujuanDaerah->nama : '-') : '',
                $i == 0 ? ($inv->container && $inv->container->etd ? \Carbon\Carbon::parse($inv->container->etd)->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->container && $inv->container->eta ? \Carbon\Carbon::parse($inv->container->eta)->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->container ? $inv->container->tipe_kontainer : '-') : '',
                $i == 0 ? ($inv->container ? $inv->container->nomor_container : '-') : '',
                $i == 0 ? strtoupper($inv->layanan->nama ?? '-') : '',
                $item ? $item->jenis_barang : '-',
                $item ? $item->koli : '-',
                $item ? number_format($item->jumlah, 3, ',', '.') : '-',
                $item ? $item->satuan : '-',
                $i == 0 ? number_format($dpp_base, 0, ',', '.') : '',
                $i == 0 ? ($fee_val > 0 ? number_format($fee_val, 0, ',', '.') : '-') : '',
                $i == 0 ? number_format(round($grand_total_val), 0, ',', '.') : '',
                $i == 0 ? mb_strtoupper($inv->pkp_status ?? '-') : '',
                $i == 0 ? $inv->tanda_terima ?? '-' : '',
                $i == 0 ? $inv->catatan_muntahan ?? '-' : '',
            ];
            $rows[] = $row;
        }
        $state['row_index']++;
        return $rows;
    }

    protected function formatFinanceRows($fin, &$state)
    {
        $rows = [];
        $inv = $fin->invoice;
        if (!$inv) return $rows;

        $items = $inv->items;
        $rowCount = count($items) > 0 ? count($items) : 1;

        $dpp_base = $items->sum(function($item) {
            if (strtoupper($item->satuan) == 'UNIT') return $item->koli * $item->harga_satuan;
            return $item->jumlah * $item->harga_satuan;
        });
        $fee_val = $inv->additionalFees->sum('harga');
        $grand_total_val = ($dpp_base + $fee_val) * (strtoupper($inv->pkp_status) == 'PKP' ? 1.011 : 1);
        $state['grand_total_tagihan'] += $grand_total_val;

        for ($i = 0; $i < $rowCount; $i++) {
            $item = $items[$i] ?? null;
            if ($item && strtolower($item->satuan) != 'unit') {
                $state['grand_total_jumlah'] += $item->jumlah;
            }

            $row = [
                '', // Spacer Col A
                $i == 0 ? $state['row_index'] : '',
                $i == 0 ? ($inv->no_invoice ?? '-') : '',
                $i == 0 ? ($inv->tgl_masuk ? $inv->tgl_masuk->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->container->nomor_container ?? '-') : '',
                $i == 0 ? ($inv->container->tipe_kontainer ?? '-') : '',
                $i == 0 ? strtoupper($inv->metode ?? '-') : '',
                $i == 0 ? ($inv->container->kapal->nama_kapal ?? '-') : '',
                $i == 0 ? ($inv->container && $inv->container->etd ? $inv->container->etd->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->container->asal->nama_tujuan ?? '-') : '',
                $i == 0 ? ($inv->container->tujuan->nama_tujuan ?? '-') : '',
                $i == 0 ? ($inv->container && $inv->container->eta ? $inv->container->eta->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->pengirim->nama ?? '-') : '',
                $i == 0 ? ($inv->pengirim->no_hp ?? '-') : '',
                $i == 0 ? ($inv->pengirim->alamat ?? '-') : '',
                $i == 0 ? ($inv->pengirim && $inv->pengirim->npwp ? $inv->pengirim->npwp : '-') : '-',
                $i == 0 ? ($inv->penerima->nama ?? '-') : '-',
                $i == 0 ? ($inv->penerima->no_hp ?? '-') : '-',
                $i == 0 ? ($inv->penerima->alamat ?? '-') : '-',
                $i == 0 ? ($inv->penerima && $inv->penerima->npwp ? $inv->penerima->npwp : '-') : '-',
                $item ? $item->jenis_barang : '-',
                $item ? $item->koli : '-',
                $item ? number_format($item->jumlah, 3, ',', '.') : '-',
                $item ? $item->satuan : '-',
                $item ? number_format($item->harga_satuan, 0, '', '') : '-',
                $item ? number_format(($item->satuan == 'UNIT' ? $item->koli * $item->harga_satuan : $item->jumlah * $item->harga_satuan), 0, '', '') : '-',
                $i == 0 ? number_format($dpp_base, 0, '', '') : '',
                $i == 0 ? ($fee_val > 0 ? number_format($fee_val, 0, '', '') : '-') : '',
                $i == 0 ? number_format($grand_total_val, 0, '', '') : '',
                $i == 0 ? strtoupper($inv->tanda_terima ?? '-') : '',
                $i == 0 ? ($fin->bap_balik ?? '-') : '',
                $i == 0 ? ($inv->tujuanDaerah->nama ?? '-') : '',
                $i == 0 ? ($inv->terima_barang ? $inv->terima_barang->format('d-M-Y') : '-') : '',
                $i == 0 ? strtoupper($fin->status_tagihan ?? '-') : '',
                $i == 0 ? strtoupper($inv->layanan->nama ?? '-') : '',
                $i == 0 ? ($fin->ditagih_ke ?? '-') : '',
                $i == 0 ? ($fin->tanggal_tagih ? \Carbon\Carbon::parse($fin->tanggal_tagih)->format('d-M-Y') : '-') : '',
                $i == 0 ? $this->calculateTunggakan($fin) : '',
                $i == 0 ? strtoupper($inv->status_pembayaran ?? '-') : '',
                $i == 0 ? mb_strtoupper($inv->pkp_status ?? '-') : '',
                $i == 0 ? ($fin->tgl_transfer ? \Carbon\Carbon::parse($fin->tgl_transfer)->format('d-M-Y') : '-') : '',
                $i == 0 ? ($inv->catatan_muntahan ?? '-') : '',
                $i == 0 ? ($fin->catatan ?? '-') : '',
            ];
            $rows[] = $row;
        }
        $state['row_index']++;
        return $rows;
    }

    protected function calculateTunggakan($fin)
    {
        if (!$fin->tanggal_tagih) return '-';
        if ($fin->tgl_transfer) return 'Lunas';
        
        $today = \Carbon\Carbon::now()->startOfDay();
        $tagih = \Carbon\Carbon::parse($fin->tanggal_tagih)->startOfDay();
        $diffDays = $tagih->diffInDays($today, false);
        return $diffDays > 0 ? intval($diffDays) . ' Hari' : '-';
    }

    protected function getQuery($type, $request)
    {
        if ($type == 'invoice') {
            $query = Invoice::query();
            
            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::parse(trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::parse(trim($dates[1]))->endOfDay();
                    $query->whereHas('container', function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('etd', [$start_date, $end_date]);
                    });
                }
            }

            if ($request->filled('status')) $query->where('status_pembayaran', $request->status);
            if ($request->filled('is_pkp')) {
                if ($request->is_pkp == '1') $query->where('pkp_status', 'PKP');
                else $query->where(function($q) { $q->where('pkp_status', '!=', 'PKP')->orWhereNull('pkp_status'); });
            }
            if ($request->filled('pengirim_id')) $query->where('pengirim_id', $request->pengirim_id);
            if ($request->filled('penerima_id')) $query->where('penerima_id', $request->penerima_id);
            if ($request->filled('asal_id')) $query->whereHas('container', function ($q) use ($request) { $q->where('asal_id', $request->asal_id); });
            if ($request->filled('tujuan_id')) $query->whereHas('container', function ($q) use ($request) { $q->where('tujuan_id', $request->tujuan_id); });
            
            return $query;
        } else {
            $query = Finance::query();
            
            $query->whereHas('invoice.container', function ($q) use ($request) {
                if ($request->filled('asal_id')) $q->where('asal_id', $request->asal_id);
                if ($request->filled('tujuan_id')) $q->where('tujuan_id', $request->tujuan_id);
            });

            if ($request->filled('pengirim_id')) {
                $query->whereHas('invoice', function ($q) use ($request) {
                    $q->where('pengirim_id', $request->pengirim_id);
                });
            }

            if ($request->filled('penerima_id')) {
                $query->whereHas('invoice', function ($q) use ($request) {
                    $q->where('penerima_id', $request->penerima_id);
                });
            }

            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::parse(trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::parse(trim($dates[1]))->endOfDay();
                    $query->whereHas('invoice.container', function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('etd', [$start_date, $end_date]);
                    });
                }
            }

            if ($request->filled('status')) $query->where('status_tagihan', $request->status);

            return $query;
        }
    }
}
