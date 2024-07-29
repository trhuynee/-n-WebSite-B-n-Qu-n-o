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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ma_hd');
            $table->unsignedBigInteger('sp_id');
            $table->unsignedBigInteger('chitietietsp_id');
            $table->integer('soluong');
            $table->string('giaohang');
            $table->string('thanhtien');
            $table->string('diachi');
            $table->timestamps();

            $table->foreign('ma_hd')->references('id')->on('order');
            $table->foreign('sp_id')->references('id')->on('product');
            $table->foreign('chitietietsp_id')->references('id')->on('product_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};