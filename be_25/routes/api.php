<?php

use App\Http\Controllers\DanhSachSPController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/admin/danh-sach-san-pham/data',[DanhSachSPController::class,'getData']);
Route::post('/admin/danh-sach-san-pham/create',[DanhSachSPController::class,'store']);


