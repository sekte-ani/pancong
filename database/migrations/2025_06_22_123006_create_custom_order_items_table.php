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
        Schema::create('custom_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('base_menu_id');
            $table->integer('qty');
            $table->decimal('base_price', 10, 2);
            $table->decimal('addons_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->json('selected_addons');
            $table->timestamps();

            $table->foreign('order_id')->references('id_pesanan')->on('orders')->onDelete('cascade');
            $table->foreign('base_menu_id')->references('id_item')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_order_items');
    }
};
