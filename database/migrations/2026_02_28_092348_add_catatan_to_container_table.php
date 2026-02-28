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
        Schema::table('container', function (Blueprint $table) {
            $table->text('catatan_invoicing')->nullable()->after('catatan');
            $table->text('catatan_finance')->nullable()->after('catatan_invoicing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('container', function (Blueprint $table) {
            $table->dropColumn(['catatan_invoicing', 'catatan_finance']);
        });
    }
};
