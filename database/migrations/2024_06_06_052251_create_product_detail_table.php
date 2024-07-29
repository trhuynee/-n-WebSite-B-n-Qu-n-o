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
        Schema::create('product_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sanpham_id');
            $table->unsignedBigInteger('mau_id');
            $table->unsignedBigInteger('size_id'); 
            $table->integer('soluong');
            $table->tinyInteger('trangthai')->default('0');
            $table->timestamps();

            $table->foreign('sanpham_id')->references('id')->on('product');
            $table->foreign('mau_id')->references('id')->on('color');
            $table->foreign('size_id')->references('id')->on('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_detail');
    }
};