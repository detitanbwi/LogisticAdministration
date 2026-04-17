<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            ['name' => 'view.layanan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create.layanan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit.layanan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete.layanan', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->whereIn('name', [
            'view.layanan',
            'create.layanan',
            'edit.layanan',
            'delete.layanan'
        ])->delete();
    }
};
