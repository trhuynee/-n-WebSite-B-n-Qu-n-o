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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('tensanpham');
            $table->longText('mota');
            $table->string('dongia');
            $table->integer('giamgia');
            $table->tinyInteger('trangthai');
            $table->timestamps();

            $table->unsignedBigInteger('loaisp_id');
            $table->unsignedBigInteger('nh_id');

            $table->foreign('loaisp_id')->references('id')->on('category');
            $table->foreign('nh_id')->references('id')->on('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};