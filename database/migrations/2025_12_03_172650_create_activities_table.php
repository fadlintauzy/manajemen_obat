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
        Schema::create('activities', function (Blueprint $table) {
            $table->id('id_activity');
            $table->foreignId('id_batch')->constrained('batches', 'id_batch')->onDelete('cascade');
            $table->enum('jenis_aktivitas', ['masuk', 'keluar', 'penyesuaian']);
            $table->integer('jumlah');
            $table->integer('sisa_stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
