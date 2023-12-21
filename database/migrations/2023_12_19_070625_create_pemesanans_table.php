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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pemesanan'); //file dari tabel pelanggan
            $table->unsignedInteger('id_pelanggan'); //file dari tabel pemesanan
            $table->string('tanggal_pemesanan');
            $table->string('tanggal_pernikahan');
            $table->bigInteger('total_biaya');
            $table->string('status_pemesanan');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
