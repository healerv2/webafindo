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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('no_invoice');
            $table->date('periode_tagihan')->nullable();
            $table->string('paket')->nullable();
            $table->integer('tarif');
            $table->foreignId('admin')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('status')->default('PENDING');
            $table->string('external_id')->nullable();
            $table->string('invoice_url')->nullable();
            $table->string('note')->nullable();
            $table->string('isolir')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
