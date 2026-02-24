<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions structure
        $resources = [
            'dashboard' => ['view'],
            'role' => ['*'],
            'user' => ['*'],
            'customer' => ['*'],
            'container' => ['*'],
            'kapal' => ['*'],
            'tujuan' => ['*'],
            'invoice' => ['*', 'print_per_invoice'],
            'finance' => ['view', 'edit'],
            'kategori_keuangan' => ['*'],
            'rekening_bank' => ['*'],
            'transaksi' => ['*'],
            'hutang' => ['*'],
            'piutang' => ['*'],
            // Example custom: 'product' => ['*', 'approve', 'reject'],
        ];

        $allPermissions = [];

        foreach ($resources as $resource => $permissions) {
            $allPermissions = array_merge($allPermissions, $this->generatePermissions($resource, $permissions));
        }

        // Create permissions if they don't exist
        // Create permissions if they don't exist
        $existingPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();
        $newPermissions = array_diff($allPermissions, $existingPermissions);

        if (!empty($newPermissions)) {
            $now = now();
            $permissionsData = collect($newPermissions)->map(function ($name) use ($now) {
                return [
                    'name' => $name,
                    'guard_name' => 'web',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->toArray();
            
            Permission::insert($permissionsData);
        }

        // Create Admin Role and Assign All Permissions
        $adminRole = Role::findOrCreate('admin');
        $adminRole->syncPermissions($allPermissions);

        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        $adminUser->assignRole($adminRole);
    }

    /**
     * Generate permission names based on resource and rules.
     *
     * Rules:
     * - ['*'] : All default permissions.
     * - ['*', 'custom'] : All default + custom permissions.
     * - ['view', 'create'] : Only specific permissions.
     */
    private function generatePermissions(string $resource, array $permissions = ['*']): array
    {
        $defaultPermissions = ['view', 'create', 'edit', 'delete', 'export', 'import', 'print'];

        if (in_array('*', $permissions)) {
            // Remove '*' from array
            $customPermissions = array_diff($permissions, ['*']);
            // Merge defaults with custom ones
            $finalPermissions = array_unique(array_merge($defaultPermissions, $customPermissions));
        } else {
            // Use only provided permissions
            $finalPermissions = $permissions;
        }

        return array_map(fn ($action) => "{$action}.{$resource}", $finalPermissions);
    }
}
