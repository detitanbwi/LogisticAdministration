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
        Schema::table('invoice', function (Blueprint $table) {
            $table->foreignId('asal_id')->nullable()->after('kapal_id')->constrained('tujuan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign(['asal_id']);
            $table->dropColumn('asal_id');
        });
    }
};
