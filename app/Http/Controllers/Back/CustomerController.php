<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StoreCustomerRequest;
use App\Http\Requests\Back\UpdateCustomerRequest;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.customer'), 403);

        if ($request->ajax()) {
            $data = Customer::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $searchValue = $request->search['value'];
                        $query->where(function($q) use ($searchValue) {
                            $q->where('nama', 'like', "%$searchValue%")
                              ->orWhere('no_hp', 'like', "%$searchValue%")
                              ->orWhere('npwp', 'like', "%$searchValue%")
                              ->orWhere('pic', 'like', "%$searchValue%")
                              ->orWhere('jabatan_pic', 'like', "%$searchValue%")
                              ->orWhere('alamat', 'like', "%$searchValue%")
                              ->orWhere('catatan', 'like', "%$searchValue%");
                        });
                    }
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.customer.edit', $row->id);
                    $btn = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.customer')) {
                        $btn .= '<a href="'.$editUrl.'" class="avatar-text avatar-md bg-soft-warning text-warning"><i class="feather feather-edit-3"></i></a>';
                    }
                    
                    if (auth()->user()->can('delete.customer')) {
                        $btn .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="'.$row->id.'"><i class="feather feather-trash-2"></i></a>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('back.pages.customer.index');
    }

    public function export()
    {
        abort_unless(auth()->user()->can('view.customer'), 403);
        return Excel::download(new CustomerExport, 'customer_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.customer'), 403);
        return view('back.pages.customer.form');
    }

    public function store(StoreCustomerRequest $request)
    {
        abort_unless(auth()->user()->can('create.customer'), 403);
        $customer = Customer::create($request->validated());

        if ($request->ajax()) {
            return response()->json($customer);
        }

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        abort_unless(auth()->user()->can('edit.customer'), 403);
        return view('back.pages.customer.form', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        abort_unless(auth()->user()->can('edit.customer'), 403);
        $customer->update($request->validated());
        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        abort_unless(auth()->user()->can('delete.customer'), 403);
        $customer->delete();
        return response()->json(['success' => 'Customer berhasil dihapus.']);
    }
}
