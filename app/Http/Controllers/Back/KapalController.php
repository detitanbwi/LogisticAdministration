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
            $data = Kapal::query();
            return DataTables::of($data)
                ->addIndexColumn()
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.pages.kapal.index');
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
