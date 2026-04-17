<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Seed initial data
        $layanans = [
            ['nama' => 'Door to Door', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'CY to CY', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'CY to Door', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Door to CY', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Port to Port', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('layanans')->insert($layanans);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
