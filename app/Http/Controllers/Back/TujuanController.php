<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreTujuanRequest;
use App\Http\Requests\Back\UpdateTujuanRequest;

class TujuanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.tujuan'), 403);

        if ($request->ajax()) {
            $data = Tujuan::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('admin.tujuan.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.tujuan')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.tujuan')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.pages.tujuan.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.tujuan'), 403);
        return view('back.pages.tujuan.form');
    }

    public function store(StoreTujuanRequest $request)
    {
        abort_unless(auth()->user()->can('create.tujuan'), 403);
        $tujuan = Tujuan::create($request->validated());

        if ($request->ajax()) {
            return response()->json($tujuan);
        }

        return redirect()->route('admin.tujuan.index')->with('success', 'Tujuan berhasil ditambahkan.');
    }

    public function edit(Tujuan $tujuan)
    {
        abort_unless(auth()->user()->can('edit.tujuan'), 403);
        return view('back.pages.tujuan.form', compact('tujuan'));
    }

    public function update(UpdateTujuanRequest $request, Tujuan $tujuan)
    {
        abort_unless(auth()->user()->can('edit.tujuan'), 403);
        $tujuan->update($request->validated());
        return redirect()->route('admin.tujuan.index')->with('success', 'Tujuan berhasil diperbarui.');
    }

    public function destroy(Tujuan $tujuan)
    {
        abort_unless(auth()->user()->can('delete.tujuan'), 403);
        $tujuan->delete();
        return response()->json(['success' => 'Tujuan berhasil dihapus.']);
    }
}
