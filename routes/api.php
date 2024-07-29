<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/danh-sach-chung', [ChungController::class, 'index'])->name('danh-sach-chung');

Route::post('/them-nhan-hieu', [ChungController::class, 'store1'])->name('them-nhan-hieu');
Route::get('/chinh-sua-nhan-hieu/{id}', [BrandController::class, 'edit'])->name('chinh-sua-nhan-hieu');
Route::post('/cap-nhat-nhan-hieu/{id}', [BrandController::class, 'update'])->name('cap-nhat-nhan-hieu');
Route::delete('/xoa-nhan-hieu/{id}', [BrandController::class, 'destroy'])->name('xoa-nhan-hieu');
