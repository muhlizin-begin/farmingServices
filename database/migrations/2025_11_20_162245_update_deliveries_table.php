<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // 1. Rename tabel lama
    Schema::rename('deliveries', 'deliveries_old');

    // 2. Buat tabel baru dengan FK yang benar
    Schema::create('deliveries', function (Blueprint $table) {
        $table->id('id_pengiriman');
        $table->date('tanggal_pengiriman');
        $table->foreignId('id_regu')->constrained('teams')->onDelete('cascade');
        $table->unsignedBigInteger('id_lokasi');
        $table->foreign('id_lokasi')
              ->references('id_lokasi')
              ->on('locations')
              ->onDelete('cascade');
        $table->string('status_lokasi');
        $table->float('berat_buah');
        $table->timestamps();
    });

    // 3. Salin data dari table lama
    DB::table('deliveries')->insert(
        DB::table('deliveries_old')->get()->map(function ($item) {
            return (array) $item;
        })->toArray()
    );

    // 4. Hapus table lama
    Schema::drop('deliveries_old');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
