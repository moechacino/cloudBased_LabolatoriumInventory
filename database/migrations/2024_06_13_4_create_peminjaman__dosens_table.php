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
        Schema::create('peminjaman__dosens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("alat_lab_id")->nullable(false);
            $table->unsignedBigInteger("dosen_id")->nullable(false);
            $table->text("keperluan")->nullable(false);
            $table->string("tempat_pemakaian", 100)->nullable(false);
            $table->date("tanggal_peminjaman")->nullable(false);
            $table->date("tanggal_pengembalian")->nullable(false);
            $table->boolean("accepted")->nullable(true);
            $table->boolean("sudah_dikembalikan")->nullable(true);
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosens');
            $table->foreign('alat_lab_id')->references('id')->on('alat__labs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman__dosens');
    }
};
