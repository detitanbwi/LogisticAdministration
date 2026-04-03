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
            $table->boolean('show_stamp')->default(true)->after('tanda_terima');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->decimal('p', 10, 2)->nullable()->after('koli');
            $table->decimal('l', 10, 2)->nullable()->after('p');
            $table->decimal('t', 10, 2)->nullable()->after('l');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('show_stamp');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn(['p', 'l', 't']);
        });
    }
};
