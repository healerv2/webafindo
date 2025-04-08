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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('area_id')->nullable()->constrained('areas')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('paket_id')->nullable()->constrained('data_paket')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('mikrotik_id')->nullable()->constrained('mikrotiks')->cascadeOnUpdate()->nullOnDelete();
            $table->integer('by_tambahan_1')->nullable();
            $table->string('keterangan_tambahan_1')->nullable();
            $table->integer('by_tambahan_2')->nullable();;
            $table->string('keterangan_tambahan_2')->nullable();
            $table->integer('diskon')->nullable();;
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('perangkat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
