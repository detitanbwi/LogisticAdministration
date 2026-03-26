<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('container_operational_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id')->constrained('container')->onDelete('cascade');
            $table->string('komponen')->nullable();
            $table->decimal('nominal', 15, 2)->default(0);
            $table->date('tanggal_transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_operational_costs');
    }
};
