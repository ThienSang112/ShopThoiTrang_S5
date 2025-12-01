<?php

namespace App\Http\Controllers;

use App\Models\DanhSachSanPham;
use Illuminate\Http\Request;
use App\Http\Requests\DanhSachSPRequest;


class DanhSachSPController extends Controller
{

    public function store(DanhSachSPRequest $request)
    {
        DanhSachSanPham::create([
            'ten_san_pham'      => $request->ten_san_pham,
            'danh_muc'          => $request->danh_muc,
            'gia_ban'           => $request->gia_ban,
            'hinh_anh'          => $request->hinh_anh,
            'mo_ta'             => $request->mo_ta,
            'tinh_trang'        => $request->tinh_trang
        ]);

        return response()->json([
            'status' => 1,
            'message'=>'Đã thêm mới sản phẩm'  .  $request->ten_san_pham  .  'thành công'
        ]);
    }

    public function getData(){
        $data = DanhSachSanPham::get();

        return response()->json([
            'data'  =>$data,
        ]);
    }
    
}
