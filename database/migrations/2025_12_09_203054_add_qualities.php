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
        Schema::create('qualities', function (Blueprint $table) {
            $table->id('id_kwalitas');
            $table->date('tanggal_kwalitas');
            $table->foreignId('id_regu')
            ->constrained('teams', 'id_regu')
            ->onDelete('cascade');
            $table->foreignId('id_lokasi')
            ->constrained('locations', 'id_lokasi')
            ->onDelete('cascade');
            $table->string('bonggol')
                ->nullable();
            $table->string('kememaran')
                ->nullable();
            $table->string('crown')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualities');
    }
};
