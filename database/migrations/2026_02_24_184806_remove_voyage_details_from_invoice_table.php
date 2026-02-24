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
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign(['kapal_id']);
            $table->dropForeign(['tujuan_id']);
            $table->dropForeign(['asal_id']);
            $table->dropColumn(['kapal_id', 'asal_id', 'tujuan_id', 'etd', 'eta', 'metode', 'tipe_kontainer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->foreignId('kapal_id')->nullable()->constrained('kapal')->cascadeOnDelete();
            $table->foreignId('tujuan_id')->nullable()->constrained('tujuan')->cascadeOnDelete();
            $table->foreignId('asal_id')->nullable()->constrained('tujuan')->cascadeOnDelete();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->enum('metode', ['FCL', 'LCL', 'Break Bulk'])->nullable();
            $table->enum('tipe_kontainer', ['20FT', '40FT', '40HC', '45HC'])->nullable();
        });
    }
};
