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
        Schema::table('customer', function (Blueprint $table) {
            $table->string('npwp')->nullable()->after('no_hp');
            $table->string('pic')->nullable()->after('npwp');
            $table->string('jabatan_pic')->nullable()->after('pic');
            $table->text('catatan')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn(['npwp', 'pic', 'jabatan_pic', 'catatan']);
        });
    }
};
