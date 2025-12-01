<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DanhSachSPRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ten_san_pham'       => 'required|min:4|max:100',
            'danh_muc'           => 'required|max:50',
            'gia_ban'            => 'required|numeric|min:0',
            'hinh_anh'           => 'required',
            'mo_ta'              => 'required|min:10',
            'tinh_trang'         => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm không được để trống',
            'ten_san_pham.min' => 'Tên sản phẩm phải ít nhất 4 ký tự',
            'ten_san_pham.max' => 'Tên sản phẩm tối đa 100 ký tự',

            'danh_muc.required' => 'Danh mục không được để trống',
            'danh_muc.max' => 'Danh mục tối đa 50 ký tự',

            'gia_ban.required' => 'Giá bán không được để trống',
            'gia_ban.numeric' => 'Giá bán phải là số',
            'gia_ban.min' => 'Giá bán phải lớn hơn hoặc bằng 0',

            'hinh_anh.required' => 'Hình ảnh không được để trống',

            'mo_ta.required' => 'Mô tả không được để trống',
            'mo_ta.min' => 'Mô tả phải ít nhất 10 ký tự',

            'tinh_trang.required' => 'Tình trạng không được để trống',
            'tinh_trang.boolean' => 'Tình trạng phải là true hoặc false',
        ];
    }
}
