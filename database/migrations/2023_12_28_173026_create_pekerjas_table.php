<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pekerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pekerja');
            $table->string('role')->default('default_role');
            $table->decimal('upah', 10, 2)->nullable();
            $table->unsignedBigInteger('id_proyek')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pekerjas');
    }
};