<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.role'), 403);

        if ($request->ajax()) {
            $roles = Role::query();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('permissions_count', function ($role) {
                    return $role->permissions->count();
                })
                ->addColumn('action', function ($role) {
                    $editUrl = route('admin.roles.edit', $role->id);
                    $action = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.role')) {
                        $action .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-warning text-warning">
                                <i class="feather feather-edit-3"></i>
                            </a>';
                    }

                    if (auth()->user()->can('delete.role')) {
                        $action .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $role->id . '">
                                <i class="feather feather-trash-2"></i>
                            </a>';
                    }

                    $action .= '</div>';
                    
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('back.pages.roles.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.role'), 403);

        $groupedPermissions = $this->getGroupedPermissions();

        return view('back.pages.roles.form', compact('groupedPermissions'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create.role'), 403);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        abort_unless(auth()->user()->can('edit.role'), 403);

        $groupedPermissions = $this->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('back.pages.roles.form', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        abort_unless(auth()->user()->can('edit.role'), 403);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        abort_unless(auth()->user()->can('delete.role'), 403);

        $role->delete();

        return response()->json(['success' => 'Role berhasil dihapus.']);
    }

    private function getGroupedPermissions(): array
    {
        return Permission::all()
            ->groupBy(function ($permission) {
                // Format: action.resource → group by resource
                $parts = explode('.', $permission->name);
                return $parts[1] ?? $parts[0];
            })
            ->map(function ($permissions, $resource) {
                return $permissions->map(function ($permission) {
                    $parts = explode('.', $permission->name);
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'action' => $parts[0] ?? $permission->name,
                    ];
                });
            })
            ->toArray();
    }
}
