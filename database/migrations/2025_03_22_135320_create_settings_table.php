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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pt');
            $table->text('alamat_pt')->nullable();
            $table->string('nama_rek_pt')->nullable();
            $table->string('no_rek_pt')->nullable();
            $table->string('nama_bank_pt')->nullable();
            $table->string('path_logo')->nullable();
            $table->string('path_ttd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
