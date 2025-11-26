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
        // 1. Ubah nama tabel lama
        Schema::rename('deliveries', 'deliveries_old');

        // 2. Buat tabel deliveries baru dengan FK yang benar
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->date('tanggal_pengiriman');

            // FK ke teams.id
            $table->unsignedBigInteger('id_regu');
            $table->foreign('id_regu')
                ->references('id_regu')
                ->on('teams')
                ->onDelete('cascade');

            // FK ke locations.id_lokasi
            $table->unsignedBigInteger('id_lokasi');
            $table->foreign('id_lokasi')
                ->references('id_lokasi')
                ->on('locations')
                ->onDelete('cascade');

            $table->string('status_lokasi');
            $table->float('berat_buah');
            $table->timestamps();
        });

        // 3. Copy data lama ke tabel baru
        $rows = DB::table('deliveries_old')->get();

        foreach ($rows as $row) {
            // Konversi object → array
            $data = (array) $row;

            // Insert ke tabel baru
            DB::table('deliveries')->insert([
                'id_pengiriman'   => $data['id_pengiriman'],
                'tanggal_pengiriman' => $data['tanggal_pengiriman'],
                'id_regu'         => $data['id_regu'],
                'id_lokasi'       => $data['id_lokasi'],
                'status_lokasi'   => $data['status_lokasi'],
                'berat_buah'      => $data['berat_buah'],
                'created_at'      => $data['created_at'],
                'updated_at'      => $data['updated_at'],
            ]);
        }

        // 4. Hapus tabel lama
        Schema::drop('deliveries_old');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
