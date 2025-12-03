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
        Schema::create('batches', function (Blueprint $table) {
            $table->id('id_batch');
            $table->foreignId('id_obat')->constrained('obats', 'id_obat')->onDelete('cascade');
            $table->foreignId('id_supplier')->constrained('suppliers', 'id_supplier')->onDelete('cascade');
            $table->string('no_batches', 50);
            $table->integer('stok');
            $table->date('tgl_penerimaan');
            $table->date('tgl_kadaluarsa');
            $table->string('lokasi_penyimpanan', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
