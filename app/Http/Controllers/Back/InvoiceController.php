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

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.invoice'), 403);

        if ($request->ajax()) {
            $query = Invoice::with(['kapal', 'tujuan', 'asal', 'pengirim', 'penerima', 'finance', 'container'])->select('invoice.*');
            
            if ($request->filled('daterange')) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                    $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('invoice.created_at', [$start_date, $end_date]);
                }
            }
            
            if ($request->filled('status')) {
                $query->where('status_pembayaran', $request->status);
            }

            if ($request->filled('asal_id')) {
                $query->where('asal_id', $request->asal_id);
            }

            if ($request->filled('tujuan_id')) {
                $query->where('tujuan_id', $request->tujuan_id);
            }
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_invoice', function($row){
                    return $row->no_invoice;
                })
                ->editColumn('etd', function($row){
                    return $row->etd ? $row->etd->format('d-m-Y') : '-';
                })
                ->addColumn('asal', function($row){
                    return $row->asal ? $row->asal->nama_tujuan : '-';
                })
                ->addColumn('tujuan', function($row){
                    return $row->tujuan ? $row->tujuan->nama_tujuan : '-';
                })
                ->addColumn('pengirim', function($row){
                    return $row->pengirim ? $row->pengirim->nama : '-';
                })
                ->addColumn('penerima', function($row){
                    return $row->penerima ? $row->penerima->nama : '-';
                })
                ->addColumn('total_tagihan', function($row){
                    return $row->finance ? number_format($row->finance->total_tagihan, 0, ',', '.') : '-';
                })
                ->addColumn('catatan_muntahan', function($row){
                    return $row->catatan_muntahan ? \Illuminate\Support\Str::limit($row->catatan_muntahan, 50) : '-';
                })
                ->editColumn('status_pembayaran', function($row){
                    $color = $row->status_pembayaran == 'Serahkan' ? 'success' : 'warning';
                    return '<span class="badge bg-soft-'.$color.' text-'.$color.'">'.$row->status_pembayaran.'</span>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.invoice.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.invoice')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('print_per_invoice.invoice')) {
                         $btn .= '<a href="'.route('admin.invoice.print', $row->id).'" class="avatar-text avatar-md bg-soft-info text-info" target="_blank"><i class="feather feather-printer"></i></a>';
                    }

                    if (auth()->user()->can('delete.invoice')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status_pembayaran', 'action'])
                ->make(true);
        }

        $tujuans = Tujuan::all();
        return view('back.pages.invoice.index', compact('tujuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->can('create.invoice'), 403);
        
        $kapals = Kapal::all();
        $tujuans = Tujuan::all();
        $customers = Customer::all();
        $containers = Container::all();
        
        return view('back.pages.invoice.form', compact('kapals', 'tujuans', 'customers', 'containers'));
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
            $invoice = Invoice::create($request->except('items'));
            
            // Create Items & Calculate Total
            $totalTagihan = 0;
            
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $subtotal = $item['jumlah'] * $item['harga_satuan'];
                    $totalTagihan += $subtotal;
                    
                    $invoice->items()->create([
                        'jenis_barang' => $item['jenis_barang'],
                        'koli' => $item['koli'],
                        'jumlah' => $item['jumlah'],
                        'satuan' => $item['satuan'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $subtotal,
                    ]);
                }
            }
            
            // Calculate PPN if PKP
            if ($request->pkp_status == 'PKP') {
                $totalTagihan += ($totalTagihan * 0.011);
            }

            // Create Finance
            $invoice->finance()->create([
                'total_tagihan' => $totalTagihan,
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
        
        $invoice->load('items', 'finance');
        $kapals = Kapal::all();
        $tujuans = Tujuan::all();
        $customers = Customer::all();
        $containers = Container::all();
        
        return view('back.pages.invoice.form', compact('invoice', 'kapals', 'tujuans', 'customers', 'containers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        abort_unless(auth()->user()->can('edit.invoice'), 403);
        
        DB::beginTransaction();
        try {
            $invoice->update($request->except('items'));
            
            // Re-create items
            $invoice->items()->delete();
            
            $totalTagihan = 0;
            
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $subtotal = $item['jumlah'] * $item['harga_satuan'];
                    $totalTagihan += $subtotal;
                    
                    $invoice->items()->create([
                        'jenis_barang' => $item['jenis_barang'],
                        'koli' => $item['koli'],
                        'jumlah' => $item['jumlah'],
                        'satuan' => $item['satuan'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $subtotal,
                    ]);
                }
            }
            
            // Calculate PPN if PKP
            if ($request->pkp_status == 'PKP') {
                $totalTagihan += ($totalTagihan * 0.011);
            }

            // Update Finance Total Tagihan
            if ($invoice->finance) {
                $invoice->finance->update(['total_tagihan' => $totalTagihan]);
            } else {
                 $invoice->finance()->create([
                    'total_tagihan' => $totalTagihan,
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
        
        $invoice->load(['kapal', 'tujuan', 'asal', 'pengirim', 'penerima', 'finance', 'items', 'upDetail']);
        
        return view('back.pages.invoice.print', compact('invoice'));
    }

    public function preview(Request $request)
    {
        abort_unless(auth()->user()->can('create.invoice') || auth()->user()->can('edit.invoice'), 403);

        $invoice = new Invoice($request->except('items'));
        $invoice->created_at = now(); // For date parsing 
        
        // Load relationships manually from DB
        $invoice->setRelation('kapal', Kapal::find($request->kapal_id));
        $invoice->setRelation('asal', Tujuan::find($request->asal_id));
        $invoice->setRelation('tujuan', Tujuan::find($request->tujuan_id));
        $invoice->setRelation('pengirim', Customer::find($request->pengirim_id));
        $invoice->setRelation('penerima', Customer::find($request->penerima_id));
        $invoice->setRelation('upDetail', Customer::find($request->up));
        $invoice->setRelation('container', Container::find($request->container_id));

        $items = collect();
        $totalTagihan = 0;
        if ($request->items) {
            foreach ($request->items as $itemData) {
                $subtotal = ($itemData['jumlah'] ?? 0) * ($itemData['harga_satuan'] ?? 0);
                $totalTagihan += $subtotal;
                
                $itemData['subtotal'] = $subtotal;
                $items->push(new \App\Models\InvoiceItem($itemData));
            }
        }
        $invoice->setRelation('items', $items);

        if ($request->pkp_status == 'PKP') {
            $totalTagihan += ($totalTagihan * 0.011);
        }

        $finance = new Finance([
            'total_tagihan' => $totalTagihan,
            'status_tagihan' => $request->status_pembayaran ?? 'Belum'
        ]);
        $invoice->setRelation('finance', $finance);

        return view('back.pages.invoice.print', compact('invoice'));
    }
}
