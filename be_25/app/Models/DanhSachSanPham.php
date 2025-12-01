<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhSachSanPham extends Model
{
    protected $table = "danh_sach_san_phams";

    protected $fillable = [
        'ten_san_pham',
        'mo_ta',
        'danh_muc',
        'gia_ban',
        'hinh_anh',
        'tinh_trang',
    ];
}
