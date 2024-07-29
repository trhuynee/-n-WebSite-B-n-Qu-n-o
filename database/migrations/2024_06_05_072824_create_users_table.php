<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('sdt')->nullable();
            $table->string('password');
            $table->string('hovaten');
            $table->string('email')->unique();;
            $table->string('diachi')->nullable();
            $table->tinyInteger('phanquyen')->default('2');
            $table->string('gioitinh')->nullable(); // Thêm cột giới tính
            $table->date('ngaysinh')->nullable(); // Thêm cột ngày sinh
            $table->string('avatar')->nullable();
            $table->tinyInteger('trangthai')->default('0');
            $table->timestamps();
        });
        DB::table('user')->insert([
            'sdt' => '0981650076',
            'password' => Hash::make('admin1'),
            'hovaten' => 'Trương Gia Huy',
            'email' => 'admin@gmail.com',
            'diachi' => 'TP.HCM',
            'phanquyen' => '1',  // Giả sử 1 là admin, 2 là người dùng bình thường
            'gioitinh' => 'Nam',
            'ngaysinh' => '2002-01-01',
            'avatar' => null,
            'trangthai' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};