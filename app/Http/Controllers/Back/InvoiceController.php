<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Kapal;
use App\Models\Tujuan;
use App\Models\Customer;
use App\Models\Finance;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Http\Requests\Back\StoreInvoiceRequest;
use App\Http\Requests\Back\UpdateInvoiceRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\TujuanDaerah;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.invoice'), 403);

        if ($request->ajax()) {
            $query = Invoice::with(['container.kapal', 'container.tujuan', 'container.asal', 'pengirim', 'penerima', 'finance', 'items', 'additionalFees'])->select('invoice.*');

            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $query->whereHas('container', function ($q) use ($start_date, $end_date) {
                        $q->whereBetween('etd', [$start_date, $end_date]);
                    });
                }
            }

            if ($request->filled('status')) {
                $query->where('status_pembayaran', $request->status);
            }

            if ($request->filled('is_pkp')) {
                if ($request->is_pkp == '1') {
                    $query->where('pkp_status', 'PKP');
                } else {
                    $query->where(function($q) {
                        $q->where('pkp_status', '!=', 'PKP')->orWhereNull('pkp_status');
                    });
                }
            }

            if ($request->filled('pengirim_id')) {
                $query->where('pengirim_id', $request->pengirim_id);
            }

            if ($request->filled('penerima_id')) {
                $query->where('penerima_id', $request->penerima_id);
            }

            if ($request->filled('asal_id')) {
                $query->whereHas('container', function ($q) use ($request) {
                    $q->where('asal_id', $request->asal_id);
                });
            }

            if ($request->filled('tujuan_id')) {
                $query->whereHas('container', function ($q) use ($request) {
                    $q->where('tujuan_id', $request->tujuan_id);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->filterColumn('no_invoice', function ($query, $keyword) {
                    $query->where('no_invoice', 'like', "%{$keyword}%");
                })
                ->filterColumn('pengirim', function ($query, $keyword) {
                    $query->whereHas('pengirim', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('penerima', function ($query, $keyword) {
                    $query->whereHas('penerima', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('asal', function ($query, $keyword) {
                    $query->whereHas('container.asal', function ($q) use ($keyword) {
                        $q->where('nama_tujuan', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('tujuan', function ($query, $keyword) {
                    $query->whereHas('container.tujuan', function ($q) use ($keyword) {
                        $q->where('nama_tujuan', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('no_invoice', function ($row) {
                    return $row->no_invoice;
                })
                ->editColumn('etd', function ($row) {
                    return $row->container && $row->container->etd ? $row->container->etd->format('d-m-Y') : '-';
                })
                ->addColumn('asal', function ($row) {
                    return $row->container && $row->container->asal ? $row->container->asal->nama_tujuan : '-';
                })
                ->addColumn('tujuan', function ($row) {
                    return $row->container && $row->container->tujuan ? $row->container->tujuan->nama_tujuan : '-';
                })
                ->addColumn('pengirim', function ($row) {
                    return $row->pengirim ? $row->pengirim->nama : '-';
                })
                ->addColumn('penerima', function ($row) {
                    return $row->penerima ? $row->penerima->nama : '-';
                })
                ->addColumn('koli', function ($row) {
                    return $row->items->pluck('koli')->implode('<br>');
                })
                ->addColumn('jumlah', function ($row) {
                    return $row->items->pluck('jumlah')->map(fn($v) => $v == 0 ? '0' : number_format($v, 3, ',', '.'))->implode('<br>');
                })
                ->addColumn('satuan', function ($row) {
                    return $row->items->pluck('satuan')->implode('<br>');
                })
                ->addColumn('total_tagihan', function ($row) {
                    $dpp_base = $row->items->sum(function($item) {
                        if (strtoupper($item->satuan) == 'UNIT') {
                            return $item->koli * $item->harga_satuan;
                        }
                        return $item->jumlah * $item->harga_satuan;
                    });
                    $fee_val = $row->additionalFees ? $row->additionalFees->sum('harga') : 0;
                    $total = $dpp_base + $fee_val;
                    if (strtoupper($row->pkp_status) == 'PKP') {
                        $total = round($total * 1.011);
                    }
                    return number_format($total, 0, ',', '.');
                })
                ->addColumn('catatan_muntahan', function ($row) {
                    return $row->catatan_muntahan ? \Illuminate\Support\Str::limit($row->catatan_muntahan, 50) : '-';
                })
                ->editColumn('status_pembayaran', function ($row) {
                    $color = $row->status_pembayaran == 'Serahkan' ? 'success' : 'warning';
                    return '<span class="badge bg-soft-' . $color . ' text-' . $color . '">' . $row->status_pembayaran . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.invoice.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';

                    if (auth()->user()->can('edit.invoice')) {
                        $btn .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }

                    if (auth()->user()->can('print_per_invoice.invoice')) {
                        $btn .= '<a href="' . route('admin.invoice.print', $row->id) . '" class="avatar-text avatar-md bg-soft-info text-info" target="_blank" title="Cetak Invoice"><i class="feather feather-printer"></i></a>';
                        $btn .= '<a href="' . route('admin.invoice.print_volume', $row->id) . '" class="avatar-text avatar-md bg-soft-primary text-primary" target="_blank" title="Rincian Volume"><i class="feather feather-layers"></i></a>';
                    }

                    if (auth()->user()->can('delete.invoice')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $row->id . '"><i class="feather feather-trash-2"></i></a>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status_pembayaran', 'action', 'koli', 'satuan', 'jumlah'])
                ->make(true);
        }

        $tujuans = Tujuan::all();
        $customers = Customer::all();
        $judulPrints = \App\Models\JudulPrint::all();
        return view('back.pages.invoice.index', compact('tujuans', 'judulPrints', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->can('create.invoice'), 403);

        $customers = Customer::all();
        $containers = Container::with(['kapal', 'asal', 'tujuan'])->get();
        $tujuanDaerahs = TujuanDaerah::all();

        return view('back.pages.invoice.form', compact('customers', 'containers', 'tujuanDaerahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        abort_unless(auth()->user()->can('create.invoice'), 403);

        DB::beginTransaction();
        try {
            $validated = $request->validated();

            // Create Invoice
            $data = $request->except('items');
            $data['show_stamp'] = $request->has('show_stamp');
            $invoice = Invoice::create($data);

            // Create Items & Calculate Total
            $totalTagihan = 0;

            $clean = function($val) {
                if ($val === null || $val === '') return 0;
                if (is_numeric($val)) return (float)$val;
                $val = str_replace('.', '', $val);
                $val = str_replace(',', '.', $val);
                return (float)$val;
            };

            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $jumlahVal = $clean($item['jumlah'] ?? 0);
                    $hargaSatuanVal = $clean($item['harga_satuan'] ?? 0);
                    
                    if (strtoupper($item['satuan'] ?? '') == 'UNIT') {
                        $subtotal = round((float)($item['koli'] ?? 0) * (float)$hargaSatuanVal);
                        $jumlahVal = 0;
                    } else {
                        $subtotal = round((float)$jumlahVal * (float)$hargaSatuanVal);
                    }
                    $totalTagihan += $subtotal;

                    $invoiceItem = $invoice->items()->create([
                        'jenis_barang' => $item['jenis_barang'],
                        'koli' => $item['koli'],
                        'p' => $item['p'] ?? null,
                        'l' => $item['l'] ?? null,
                        't' => $item['t'] ?? null,
                        'jumlah' => $jumlahVal,
                        'satuan' => $item['satuan'],
                        'harga_satuan' => $hargaSatuanVal,
                        'subtotal' => $subtotal,
                    ]);

                    // Save nested details if any
                    if (isset($item['details']) && is_array($item['details'])) {
                        foreach ($item['details'] as $detail) {
                            $invoiceItem->details()->create([
                                'p' => $detail['p'] ?? null,
                                'l' => $detail['l'] ?? null,
                                't' => $detail['t'] ?? null,
                                'koli' => $detail['koli'] ?? null,
                                'jumlah' => $clean($detail['jumlah'] ?? 0),
                            ]);
                        }
                    }
                }
            }

            if ($request->has('additional_fees')) {
                foreach ($request->additional_fees as $fee) {
                    if (!empty($fee['nama']) && !empty($fee['harga'])) {
                        $invoice->additionalFees()->create([
                            'nama' => $fee['nama'],
                            'harga' => $fee['harga']
                        ]);
                        $totalTagihan += $fee['harga'];
                    }
                }
            }

            // Calculate PPN if PKP
            if ($request->pkp_status == 'PKP') {
                $totalTagihan += round($totalTagihan * 0.011);
            }

            // Create Finance
            $invoice->finance()->create([
                'total_tagihan' => round($totalTagihan),
                'ditagih_ke' => 'Penerima', // Default
                'status_tagihan' => 'Belum',
            ]);

            DB::commit();

            return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        abort_unless(auth()->user()->can('edit.invoice'), 403);

        $invoice->load('items.details', 'finance', 'additionalFees');
        $customers = Customer::all();
        $containers = Container::with(['kapal', 'asal', 'tujuan'])->get();
        $tujuanDaerahs = TujuanDaerah::all();

        return view('back.pages.invoice.form', compact('invoice', 'customers', 'containers', 'tujuanDaerahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        abort_unless(auth()->user()->can('edit.invoice'), 403);

        DB::beginTransaction();
        try {
            $data = $request->except('items');
            $data['show_stamp'] = $request->has('show_stamp');
            $invoice->update($data);

            // Re-create items
            $invoice->items()->delete();

            $totalTagihan = 0;

            $clean = function($val) {
                if ($val === null || $val === '') return 0;
                if (is_numeric($val)) return (float)$val;
                $val = str_replace('.', '', $val);
                $val = str_replace(',', '.', $val);
                return (float)$val;
            };

            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $jumlahVal = $clean($item['jumlah'] ?? 0);
                    $hargaSatuanVal = $clean($item['harga_satuan'] ?? 0);
                    
                    if (strtoupper($item['satuan'] ?? '') == 'UNIT') {
                        $subtotal = round((float)($item['koli'] ?? 0) * (float)$hargaSatuanVal);
                        $jumlahVal = 0;
                    } else {
                        $subtotal = round((float)$jumlahVal * (float)$hargaSatuanVal);
                    }
                    $totalTagihan += $subtotal;

                    $invoiceItem = $invoice->items()->create([
                        'jenis_barang' => $item['jenis_barang'],
                        'koli' => $item['koli'],
                        'p' => $item['p'] ?? null,
                        'l' => $item['l'] ?? null,
                        't' => $item['t'] ?? null,
                        'jumlah' => $jumlahVal,
                        'satuan' => $item['satuan'],
                        'harga_satuan' => $hargaSatuanVal,
                        'subtotal' => $subtotal,
                    ]);

                    // Save nested details if any
                    if (isset($item['details']) && is_array($item['details'])) {
                        foreach ($item['details'] as $detail) {
                            $invoiceItem->details()->create([
                                'p' => $detail['p'] ?? null,
                                'l' => $detail['l'] ?? null,
                                't' => $detail['t'] ?? null,
                                'koli' => $detail['koli'] ?? null,
                                'jumlah' => $clean($detail['jumlah'] ?? 0),
                            ]);
                        }
                    }
                }
            }

            $invoice->additionalFees()->delete();
            if ($request->has('additional_fees')) {
                foreach ($request->additional_fees as $fee) {
                    if (!empty($fee['nama']) && !empty($fee['harga'])) {
                        $invoice->additionalFees()->create([
                            'nama' => $fee['nama'],
                            'harga' => $fee['harga']
                        ]);
                        $totalTagihan += $fee['harga'];
                    }
                }
            }

            // Calculate PPN if PKP
            if ($request->pkp_status == 'PKP') {
                $totalTagihan += round($totalTagihan * 0.011);
            }

            // Update Finance Total Tagihan
            if ($invoice->finance) {
                $invoice->finance->update(['total_tagihan' => round($totalTagihan)]);
            } else {
                $invoice->finance()->create([
                    'total_tagihan' => round($totalTagihan),
                    'ditagih_ke' => 'Penerima',
                    'status_tagihan' => 'Belum',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        abort_unless(auth()->user()->can('delete.invoice'), 403);

        DB::beginTransaction();
        try {
            if ($invoice->finance) {
                $invoice->finance()->delete();
            }
            $invoice->additionalFees()->delete();
            $invoice->items()->delete();
            $invoice->delete();

            DB::commit();
            return response()->json(['success' => 'Invoice berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus invoice.'], 500);
        }
    }

    public function print(Invoice $invoice)
    {
        abort_unless(auth()->user()->can('print.invoice') || auth()->user()->can('view.invoice'), 403);

        $invoice->load(['container.kapal', 'container.tujuan', 'container.asal', 'pengirim', 'penerima', 'finance', 'items', 'additionalFees', 'upDetail', 'tujuanDaerah']);

        return view('back.pages.invoice.print', compact('invoice'));
    }

    public function printVolume(Invoice $invoice)
    {
        abort_unless(auth()->user()->can('print.invoice') || auth()->user()->can('view.invoice'), 403);

        $invoice->load(['items.details', 'pengirim', 'penerima']);

        return view('back.pages.invoice.print_volume', compact('invoice'));
    }

    public function preview(Request $request)
    {
        abort_unless(auth()->user()->can('create.invoice') || auth()->user()->can('edit.invoice'), 403);

        $invoice = new Invoice($request->except('items'));
        $invoice->created_at = now(); // For date parsing 

        // Load relationships manually from DB
        $invoice->setRelation('pengirim', Customer::find($request->pengirim_id));
        $invoice->setRelation('penerima', Customer::find($request->penerima_id));
        $invoice->setRelation('upDetail', Customer::find($request->up));

        $container = Container::with(['kapal', 'asal', 'tujuan'])->find($request->container_id);
        $invoice->setRelation('container', $container);
        $invoice->setRelation('tujuanDaerah', TujuanDaerah::find($request->tujuan_daerah_id));

        $items = collect();
        $totalTagihan = 0;
        if ($request->items) {
            foreach ($request->items as $itemData) {
                // If value from hidden input is clean (only dot/no comma), treat it as clean float
                // If it has comma, it's Indonesian format, so clean dots then replace comma.
                $rawJumlah = $itemData['jumlah'] ?? 0;
                $rawHarga = $itemData['harga_satuan'] ?? 0;

                $clean = function($val) {
                    if (strpos($val, ',') !== false) {
                        return str_replace(',', '.', str_replace('.', '', $val));
                    }
                    return $val;
                };

                $jumlahVal = $clean($rawJumlah);
                $hargaSatuanVal = $clean($rawHarga);
                
                $subtotal = (float)$jumlahVal * (float)$hargaSatuanVal;
                $totalTagihan += $subtotal;

                $itemData['jumlah'] = $jumlahVal;
                $itemData['harga_satuan'] = $hargaSatuanVal;
                $itemData['subtotal'] = $subtotal;
                
                $invoiceItem = new \App\Models\InvoiceItem($itemData);
                
                // Handle nested details in preview
                $details = collect();
                if (isset($itemData['details']) && is_array($itemData['details'])) {
                    foreach ($itemData['details'] as $detailData) {
                        $detailData['jumlah'] = $clean($detailData['jumlah'] ?? 0);
                        $details->push(new \App\Models\InvoiceItemDetail($detailData));
                    }
                }
                $invoiceItem->setRelation('details', $details);
                
                $items->push($invoiceItem);
            }
        }
        $invoice->setRelation('items', $items);

        $addFees = collect();
        if ($request->additional_fees) {
            foreach ($request->additional_fees as $fee) {
                if (!empty($fee['nama']) && !empty($fee['harga'])) {
                    $totalTagihan += $fee['harga'];
                    $addFees->push(new \App\Models\InvoiceAdditionalFee($fee));
                }
            }
        }
        $invoice->setRelation('additionalFees', $addFees);

        if ($request->pkp_status == 'PKP') {
            $totalTagihan += round($totalTagihan * 0.011);
        }

        $finance = new Finance([
            'total_tagihan' => round($totalTagihan),
            'status_tagihan' => $request->status_pembayaran ?? 'Belum'
        ]);
        $invoice->setRelation('finance', $finance);

        return view('back.pages.invoice.print', compact('invoice'));
    }

    public function export(Request $request)
    {
        abort_unless(auth()->user()->can('view.invoice') || auth()->user()->can('print.invoice'), 403);

        $query = $this->getFilteredInvoices($request);

        $judulPrint = null;
        if ($request->filled('judul_print_id')) {
            $judulObj = \App\Models\JudulPrint::find($request->judul_print_id);
            if ($judulObj) {
                $judulPrint = $judulObj->nama;
            }
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\InvoiceRecapExport($query->get(), [
            'judul_print' => $judulPrint,
            'daterange' => $request->daterange
        ]), 'InvoiceRekap_' . date('YmdHis') . '.xlsx');
    }

    public function rekapPrint(Request $request)
    {
        abort_unless(auth()->user()->can('view.invoice') || auth()->user()->can('print.invoice'), 403);

        $query = $this->getFilteredInvoices($request);
        $invoices = $query->get();

        $filters = [
            'judul_print' => 'REKAPITULASI INVOICE',
            'daterange' => $request->daterange
        ];

        if ($request->filled('judul_print_id')) {
            $judulObj = \App\Models\JudulPrint::find($request->judul_print_id);
            if ($judulObj) {
                $filters['judul_print'] = $judulObj->nama;
            }
        }

        return view('back.pages.invoice.rekap_print', compact('invoices', 'filters'));
    }

    protected function getFilteredInvoices(Request $request)
    {
        $query = Invoice::with(['container.kapal', 'container.tujuan', 'container.asal', 'pengirim', 'penerima', 'finance', 'additionalFees', 'tujuanDaerah', 'items', 'upDetail'])->select('invoice.*');

        if ($request->filled('daterange')) {
            $dates = explode(' - ', $request->daterange);
            if (count($dates) == 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereHas('container', function ($q) use ($start_date, $end_date) {
                    $q->whereBetween('etd', [$start_date, $end_date]);
                });
            }
        }

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->filled('is_pkp')) {
            if ($request->is_pkp == '1') {
                $query->where('pkp_status', 'PKP');
            } else {
                $query->where(function($q) {
                    $q->where('pkp_status', '!=', 'PKP')->orWhereNull('pkp_status');
                });
            }
        }

        if ($request->filled('pengirim_id')) {
            $query->where('pengirim_id', $request->pengirim_id);
        }

        if ($request->filled('penerima_id')) {
            $query->where('penerima_id', $request->penerima_id);
        }

        if ($request->filled('asal_id')) {
            $query->whereHas('container', function ($q) use ($request) {
                $q->where('asal_id', $request->asal_id);
            });
        }

        if ($request->filled('tujuan_id')) {
            $query->whereHas('container', function ($q) use ($request) {
                $q->where('tujuan_id', $request->tujuan_id);
            });
        }

        if ($request->filled('search')) { // from datatables search
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('no_invoice', 'like', "%{$keyword}%")
                    ->orWhereHas('pengirim', function ($q2) use ($keyword) {
                        $q2->where('nama', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('penerima', function ($q3) use ($keyword) {
                        $q3->where('nama', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('container.asal', function ($q4) use ($keyword) {
                        $q4->where('nama_tujuan', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('container.tujuan', function ($q5) use ($keyword) {
                        $q5->where('nama_tujuan', 'like', "%{$keyword}%");
                    });
            });
        }

        return $query;
    }
}
