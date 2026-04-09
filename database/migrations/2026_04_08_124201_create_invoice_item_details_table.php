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
        Schema::create('invoice_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_item_id')->constrained('invoice_items')->onDelete('cascade');
            $table->decimal('p', 12, 2)->nullable();
            $table->decimal('l', 12, 2)->nullable();
            $table->decimal('t', 12, 2)->nullable();
            $table->integer('koli')->nullable();
            $table->decimal('jumlah', 12, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_item_details');
    }
};
