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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembeli');
            $table->string('email')->nullable();
            $table->string('no_telepon');
            $table->string('alamat');
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['menunggu', 'diproses', 'dikirim', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
