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
    Schema::create('tracks', function (Blueprint $table) {
        $table->increments('id_lacak');
        $table->integer('id_order')->nullable()->default(null);
        $table->integer('no_resi')->nullable()->default(null);
        $table->integer('estimasi_waktu')->nullable()->default(null);
        $table->string('status')->nullable()->default(null);
        $table->string('lokasi')->nullable()->default(null);
        $table->string('konfirmasi_pengiriman')->nullable()->default(null);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
