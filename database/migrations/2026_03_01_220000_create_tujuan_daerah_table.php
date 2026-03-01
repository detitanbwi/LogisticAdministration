<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tujuan_daerah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::table('container', function (Blueprint $table) {
            $table->unsignedBigInteger('tujuan_daerah_id')->nullable()->after('tujuan_id');
            $table->foreign('tujuan_daerah_id')->references('id')->on('tujuan_daerah')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('container', function (Blueprint $table) {
            $table->dropForeign(['tujuan_daerah_id']);
            $table->dropColumn('tujuan_daerah_id');
        });

        Schema::dropIfExists('tujuan_daerah');
    }
};
