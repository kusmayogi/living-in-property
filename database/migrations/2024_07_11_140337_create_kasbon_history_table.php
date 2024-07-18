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
        Schema::create('kasbon_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pekerja');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('id_pekerja')->references('id_pekerja')->on('pekerjas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasbon_history');
    }
};
