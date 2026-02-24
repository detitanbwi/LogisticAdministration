<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('contr_seal');
            $table->foreignId('container_id')->nullable()->after('tgl_masuk')->constrained('container')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign(['container_id']);
            $table->dropColumn('container_id');
            $table->string('contr_seal')->nullable()->after('tgl_masuk');
        });
    }
};
