<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('finance', function (Blueprint $table) {
            $table->date('tanggal_tagih')->nullable()->after('status_tagihan');
        });
    }

    public function down(): void
    {
        Schema::table('finance', function (Blueprint $table) {
            $table->dropColumn('tanggal_tagih');
        });
    }
};
