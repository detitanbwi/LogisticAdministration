<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Kapal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreKapalRequest;
use App\Http\Requests\Back\UpdateKapalRequest;

class KapalController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.kapal'), 403);

        if ($request->ajax()) {
            $startDate = \Carbon\Carbon::now()->startOfMonth();
            $endDate = \Carbon\Carbon::now()->endOfMonth();

            $daterange = $request->input('daterange');
            $isAllTime = $request->has('daterange') && empty($daterange);

            if ($daterange) {
                $dates = explode(' - ', $daterange);
                if (count($dates) == 2) {
                    try {
                        $startDate = \Carbon\Carbon::parseIndonesian(trim($dates[0]))->startOfDay();
                        $endDate = \Carbon\Carbon::parseIndonesian(trim($dates[1]))->endOfDay();
                    } catch (\Exception $e) {
                        // Fallback to default
                    }
                }
            }

            $data = Kapal::query()
                ->withCount(['containers as total_container' => function($q) use ($startDate, $endDate, $isAllTime) {
                    if (!$isAllTime) {
                        $q->whereBetween('etd', [$startDate, $endDate]);
                    }
                }])
                ->withCount(['invoices as total_invoice' => function($q) use ($startDate, $endDate, $isAllTime) {
                    if (!$isAllTime) {
                        $q->whereHas('container', function($qc) use ($startDate, $endDate) {
                            $qc->whereBetween('etd', [$startDate, $endDate]);
                        });
                    }
                }]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('total_container', function($row) {
                    return '<span class="badge bg-soft-info text-info px-3">' . ($row->total_container ?? 0) . ' Container</span>';
                })
                ->editColumn('total_invoice', function($row) {
                    return '<span class="badge bg-soft-primary text-primary px-3">' . ($row->total_invoice ?? 0) . ' Invoice</span>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.kapal.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.kapal')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.kapal')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['total_container', 'total_invoice', 'action'])
                ->make(true);
        }
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        $daterange = $startDate->translatedFormat('d-M-Y') . ' - ' . $endDate->translatedFormat('d-M-Y');

        return view('back.pages.kapal.index', compact('daterange'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.kapal'), 403);
        return view('back.pages.kapal.form');
    }

    public function store(StoreKapalRequest $request)
    {
        abort_unless(auth()->user()->can('create.kapal'), 403);
        $kapal = Kapal::create($request->validated());
        
        if ($request->ajax()) {
            return response()->json($kapal);
        }
        
        return redirect()->route('admin.kapal.index')->with('success', 'Kapal berhasil ditambahkan.');
    }

    public function edit(Kapal $kapal)
    {
        abort_unless(auth()->user()->can('edit.kapal'), 403);
        return view('back.pages.kapal.form', compact('kapal'));
    }

    public function update(UpdateKapalRequest $request, Kapal $kapal)
    {
        abort_unless(auth()->user()->can('edit.kapal'), 403);
        $kapal->update($request->validated());
        return redirect()->route('admin.kapal.index')->with('success', 'Kapal berhasil diperbarui.');
    }

    public function destroy(Kapal $kapal)
    {
        abort_unless(auth()->user()->can('delete.kapal'), 403);
        $kapal->delete();
        return response()->json(['success' => 'Kapal berhasil dihapus.']);
    }
}
