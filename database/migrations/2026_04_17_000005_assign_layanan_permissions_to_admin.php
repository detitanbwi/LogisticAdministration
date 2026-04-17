<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Forget cached permissions to ensure the newly added ones are found
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::where('name', 'admin')->first();
        if ($role) {
            $permissions = [
                'view.layanan',
                'create.layanan',
                'edit.layanan',
                'delete.layanan'
            ];
            $role->givePermissionTo($permissions);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $role = Role::where('name', 'admin')->first();
        if ($role) {
            $permissions = [
                'view.layanan',
                'create.layanan',
                'edit.layanan',
                'delete.layanan'
            ];
            $role->revokePermissionTo($permissions);
        }
    }
};
