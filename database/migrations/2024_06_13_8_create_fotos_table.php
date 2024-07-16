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
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->string("filename",200)->nullable(false);
            $table->string("path",200)->nullable(false);
            $table->unsignedBigInteger("alert_id")->nullable(false);
            $table->timestamps();

            $table->foreign('alert_id')->references('id')->on('alert__pencurians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
