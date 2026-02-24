<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\BankRekening;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreBankRekeningRequest;
use App\Http\Requests\Back\UpdateBankRekeningRequest;

class BankRekeningController extends Controller
{
    private function getBankOptions()
    {
        if (!file_exists(config_path('bank.json'))) {
            return [];
        }
        $banks = json_decode(file_get_contents(config_path('bank.json')), true);
        return collect($banks)->mapWithKeys(function ($item) {
            return [$item['name'] => $item['name']];
        })->toArray();
    }

    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.rekening_bank'), 403);

        if ($request->ajax()) {
            $data = BankRekening::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('saldo', function($row){
                    $color = $row->saldo < 0 ? 'danger' : 'dark';
                    return '<span class="text-'.$color.' fw-bold">Rp ' . number_format($row->saldo, 0, ',', '.').'</span>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.bank-rekening.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.rekening_bank')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.rekening_bank')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'saldo'])
                ->make(true);
        }

        return view('back.pages.bank-rekening.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.rekening_bank'), 403);
        $bankOptions = $this->getBankOptions();
        return view('back.pages.bank-rekening.form', compact('bankOptions'));
    }

    public function store(StoreBankRekeningRequest $request)
    {
        abort_unless(auth()->user()->can('create.rekening_bank'), 403);
        $rekening = BankRekening::create($request->validated());
        
        if ($request->ajax()) {
            return response()->json($rekening);
        }
        
        return redirect()->route('admin.bank-rekening.index')->with('success', 'Rekening Bank berhasil ditambahkan.');
    }

    public function edit(BankRekening $bankRekening)
    {
        abort_unless(auth()->user()->can('edit.rekening_bank'), 403);
        $bankOptions = $this->getBankOptions();
        return view('back.pages.bank-rekening.form', compact('bankRekening', 'bankOptions'));
    }

    public function update(UpdateBankRekeningRequest $request, BankRekening $bankRekening)
    {
        abort_unless(auth()->user()->can('edit.rekening_bank'), 403);
        $bankRekening->update($request->validated());
        return redirect()->route('admin.bank-rekening.index')->with('success', 'Rekening Bank berhasil diperbarui.');
    }

    public function destroy(BankRekening $bankRekening)
    {
        abort_unless(auth()->user()->can('delete.rekening_bank'), 403);
        $bankRekening->delete();
        return response()->json(['success' => 'Rekening Bank berhasil dihapus.']);
    }
}
