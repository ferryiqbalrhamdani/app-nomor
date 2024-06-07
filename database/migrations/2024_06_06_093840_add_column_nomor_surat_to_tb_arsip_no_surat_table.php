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
        Schema::table('tb_arsip_no_surat', function (Blueprint $table) {
            $table->string('nomor_surat')->after('pic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_arsip_no_surat', function (Blueprint $table) {
            $table->dropColumn('nomor_surat');
        });
    }
};
