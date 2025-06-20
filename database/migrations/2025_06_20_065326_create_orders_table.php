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
            $table->id('id_pesanan');
            $table->unsignedBigInteger('pelanggan_id');
            $table->date('waktu_pesanan')->useCurrent();
            $table->decimal('total_harga',10,2)->nullable();
            $table->string('no_meja', 10)->nullable();
            $table->string('catatan')->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Process', 'Ready', 'Done'])->default('Pending');
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id_akun')->on('users')->onDelete('cascade');
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
