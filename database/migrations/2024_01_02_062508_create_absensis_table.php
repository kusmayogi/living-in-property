<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_pekerja');
        $table->date('tanggal');
        $table->enum('status', ['hadir', 'setengah_hari', 'izin']); // Sesuaikan dengan kebutuhan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
