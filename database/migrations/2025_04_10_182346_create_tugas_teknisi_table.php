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
        Schema::create('tugas_teknisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('teknisi')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('tugas_id');
            $table->string('tugas');
            $table->string('status')->default('PENDING');
            $table->dateTime('pending')->nullable();
            $table->dateTime('proses')->nullable();
            $table->dateTime('done')->nullable();
            $table->string('kerusakan')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_teknisi');
    }
};
