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
        Schema::create('tb_arsip_no_surat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_surat')->unsigned();
            $table->foreign('id_surat')->references('id')->on('tb_no_surat')->onDelete('cascade');
            $table->string('pic');
            $table->timestamp('tgl_surat');
            $table->string('keterangan_arsip');
            $table->string('keterangan');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_arsip_no_surat');
    }
};
