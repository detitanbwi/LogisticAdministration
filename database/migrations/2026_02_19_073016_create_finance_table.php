<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->unique()->constrained('invoice')->cascadeOnDelete();
            $table->decimal('total_tagihan', 15, 2);
            $table->enum('ditagih_ke', ['Pengirim', 'Penerima']);
            $table->enum('status_tagihan', ['Sudah ditagih', 'Belum'])->default('Belum');
            $table->date('tgl_transfer')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance');
    }
};
