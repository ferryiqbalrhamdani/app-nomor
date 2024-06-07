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
        Schema::create('tb_no_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('pt_slug'); // Slug dari PT
            $table->timestamp('tgl_surat')->nullable();
            $table->unsignedSmallInteger('tgl')->nullable();
            $table->unsignedTinyInteger('bulan')->nullable();
            $table->unsignedSmallInteger('tahun');
            $table->string('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_no_surat');
    }
};
