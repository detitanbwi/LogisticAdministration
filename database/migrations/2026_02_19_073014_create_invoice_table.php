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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->foreignId('kapal_id')->constrained('kapal')->cascadeOnDelete();
            $table->foreignId('tujuan_id')->constrained('tujuan')->cascadeOnDelete(); // Note: migrations for 'tujuan' might be 'tujuan' or 'pelabuhans'. Keeping 'tujuan' as user reverted 'pelabuhans'.
            $table->foreignId('pengirim_id')->constrained('customer')->cascadeOnDelete();
            $table->foreignId('penerima_id')->constrained('customer')->cascadeOnDelete();
            $table->date('etd');
            $table->date('eta')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->string('contr_seal')->nullable();
            $table->enum('metode', ['FCL', 'LCL', 'Break Bulk']);
            $table->enum('tipe_kontainer', ['20FT', '40FT', '40HC', '45HC']);
            $table->enum('layanan', ['Door to Door', 'CY to CY', 'CY to Door', 'Door to CY', 'Port to Port']);
            $table->enum('bap_balik', ['Sudah', 'Belum'])->default('Belum');
            $table->enum('status_pembayaran', ['Serahkan', 'Tahan'])->default('Tahan');
            $table->enum('pkp_status', ['PKP', 'Non PKP']);
            $table->date('terima_barang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
