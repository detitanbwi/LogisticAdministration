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
        Schema::create('hutang_piutang', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('jenis', ['Hutang', 'Piutang']);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->decimal('nominal', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_piutang');
    }
};
