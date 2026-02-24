<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Container;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Container::select('*');
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    if (auth()->user()->can('edit.container')) {
                        $btn .= '<a href="' . route('admin.container.edit', $row->id) . '" class="avatar-text avatar-md bg-soft-warning text-warning" title="Edit"><i class="feather feather-edit-3"></i></a>';
                    }
                    if (auth()->user()->can('delete.container')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $row->id . '" title="Hapus"><i class="feather feather-trash-2"></i></a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('back.pages.container.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.container.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_container' => 'required|string|max:255|unique:container,nomor_container',
        ]);

        $container = Container::create($request->all());

        if ($request->ajax()) {
            return response()->json($container);
        }

        return redirect()->route('admin.container.index')->with('success', 'Data Container berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Container $container)
    {
        return view('back.pages.container.form', compact('container'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Container $container)
    {
        $request->validate([
            'nomor_container' => 'required|string|max:255|unique:container,nomor_container,' . $container->id,
        ]);

        $container->update($request->all());

        return redirect()->route('admin.container.index')->with('success', 'Data Container berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Container $container)
    {
        try {
            $container->delete();
            return response()->json(['success' => 'Data Container berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data. ' . $e->getMessage()], 500);
        }
    }
}
