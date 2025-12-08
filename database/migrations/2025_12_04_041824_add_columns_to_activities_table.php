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
        Schema::table('activities', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('jumlah');
            $table->foreignId('user_id')->nullable()->after('keterangan'); // Removing constraint for now to avoid issues if user table logic is complex, or just use integer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['keterangan', 'user_id']);
        });
    }
};
