<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_status', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->timestamps();
        });

        DB::table('order_status')->insert([
            ['value' => 'Đang Xử Lý'],
            ['value' => 'Đang Giao Hàng'],
            ['value' => 'Đã Xong'],
            ['value' => 'Đã Hủy'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status');
    }
};
