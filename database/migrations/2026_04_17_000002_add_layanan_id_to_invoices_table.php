<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('layanan_id')->nullable()->after('layanan');
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('set null');
        });

        // Data Migration Logic
        $layanans = DB::table('layanans')->pluck('id', 'nama')->toArray();
        // $layanans is now ['Door to Door' => 1, 'CY to CY' => 2, ...]

        $invoices = DB::table('invoice')->select('id', 'layanan')->get();

        foreach ($invoices as $invoice) {
            if (isset($layanans[$invoice->layanan])) {
                DB::table('invoice')
                    ->where('id', $invoice->id)
                    ->update(['layanan_id' => $layanans[$invoice->layanan]]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign(['layanan_id']);
            $table->dropColumn('layanan_id');
        });
    }
};
