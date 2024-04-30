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
        Schema::create('ijazah', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('dosen_id');
            $table->string('institusi')->nullable();
            $table->string('program_study')->nullable();
            $table->string('gelar')->nullable();
            $table->string('tgl_lulus')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_ijazah');
    }
};
