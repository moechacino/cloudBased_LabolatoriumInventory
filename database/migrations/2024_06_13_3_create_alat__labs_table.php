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
        Schema::create('alat__labs', function (Blueprint $table) {
            $table->id();
            $table->string("rfid_uid", 100)->nullable(false)->unique(true);
            $table->string("name",200)->nullable(false);
            $table->boolean("isNeedPermission")->nullable(false)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat__labs');
    }
};
