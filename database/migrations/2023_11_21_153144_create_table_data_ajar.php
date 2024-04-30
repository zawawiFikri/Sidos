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
        Schema::create('data_ajar', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('dosen_id');
            $table->string('matkul')->nullable();
            $table->string('sks')->nullable();
            $table->string('kelas')->nullable();
            $table->string('thn_ajar')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ajar');
    }
};
