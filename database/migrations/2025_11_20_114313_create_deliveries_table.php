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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->foreignId('id_regu')->constrained('teams')->onDelete('cascade');
            $table->foreignId('id_lokasi')->constrained('locations')->onDelete('cascade');
            $table->string('status_lokasi');
            $table->float('berat_buah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
