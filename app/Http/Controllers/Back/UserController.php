<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Back\StoreUserRequest;
use App\Http\Requests\Back\UpdateUserRequest;

class UserController extends Controller
{
    // ... public function index remains same

    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view.user'), 403);

        if ($request->ajax()) {
            $users = User::with('roles')->select('users.*');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($user) {
                    return $user->roles->map(function ($role) {
                        return '<span class="badge bg-primary">' . $role->name . '</span>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('admin.users.edit', $user->id);
                    $action = '<div class="hstack gap-2 justify-content-end">';
                    
                    if (auth()->user()->can('edit.user')) {
                        $action .= '<a href="' . $editUrl . '" class="avatar-text avatar-md bg-soft-warning text-warning">
                                <i class="feather feather-edit-3"></i>
                            </a>';
                    }

                    if (auth()->user()->can('delete.user')) {
                        // Prevent deleting self
                        if (auth()->id() !== $user->id) {
                            $action .= '<a href="javascript:void(0)" class="avatar-text avatar-md bg-soft-danger text-danger delete-btn" data-id="' . $user->id . '">
                                    <i class="feather feather-trash-2"></i>
                                </a>';
                        }
                    }

                    $action .= '</div>';
                    
                    return $action;
                })
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        return view('back.pages.users.index');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create.user'), 403);

        $roles = Role::pluck('name', 'name')->all();
        return view('back.pages.users.form', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(auth()->user()->can('create.user'), 403);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        abort_unless(auth()->user()->can('edit.user'), 403);

        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->first()->name ?? null;

        return view('back.pages.users.form', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(auth()->user()->can('edit.user'), 403);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->can('delete.user'), 403);

        if (auth()->id() === $user->id) {
            return response()->json(['error' => 'Tidak dapat menghapus akun sendiri.'], 403);
        }

        $user->roles()->detach();
        $user->delete();

        return response()->json(['success' => 'User berhasil dihapus.']);
    }
}
