<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Add tujuan_daerah_id to invoice table
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('tujuan_daerah_id')->nullable()->after('layanan');
            $table->foreign('tujuan_daerah_id')->references('id')->on('tujuan_daerah')->nullOnDelete();
        });

        // 2. Migrate existing data: copy tujuan_daerah_id from container to invoice
        DB::statement('
            UPDATE invoice
            INNER JOIN container ON invoice.container_id = container.id
            SET invoice.tujuan_daerah_id = container.tujuan_daerah_id
            WHERE container.tujuan_daerah_id IS NOT NULL
        ');

        // 3. Remove tujuan_daerah_id from container table
        Schema::table('container', function (Blueprint $table) {
            $table->dropForeign(['tujuan_daerah_id']);
            $table->dropColumn('tujuan_daerah_id');
        });
    }

    public function down(): void
    {
        // 1. Add tujuan_daerah_id back to container table
        Schema::table('container', function (Blueprint $table) {
            $table->unsignedBigInteger('tujuan_daerah_id')->nullable()->after('tujuan_id');
            $table->foreign('tujuan_daerah_id')->references('id')->on('tujuan_daerah')->nullOnDelete();
        });

        // 2. Migrate data back: copy tujuan_daerah_id from invoice to container
        DB::statement('
            UPDATE container
            INNER JOIN invoice ON invoice.container_id = container.id
            SET container.tujuan_daerah_id = invoice.tujuan_daerah_id
            WHERE invoice.tujuan_daerah_id IS NOT NULL
        ');

        // 3. Remove tujuan_daerah_id from invoice table
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign(['tujuan_daerah_id']);
            $table->dropColumn('tujuan_daerah_id');
        });
    }
};
