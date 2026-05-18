<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_total_pendapatan.dashboard',
            'view_rekapitulasi.finance',
            'view_container_cost.finance',
        ];

        foreach ($permissions as $perm) {
            Permission::findOrCreate($perm, 'web');
        }

        // Grant all to admin
        $admin = Role::findByName('admin');
        if ($admin) {
            $admin->givePermissionTo($permissions);
        }

        // For any role that had view.finance (e.g. Direktur), grant the new finance permissions
        foreach (Role::all() as $role) {
            if ($role->hasPermissionTo('view.finance')) {
                $role->givePermissionTo(['view_rekapitulasi.finance', 'view_container_cost.finance']);
            }
            if ($role->hasPermissionTo('view.dashboard')) {
                $role->givePermissionTo('view_total_pendapatan.dashboard');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
