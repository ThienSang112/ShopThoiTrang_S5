<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Thêm Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <label><b>Tên sản phẩm</b></label>
                        <input v-model="create.ten_san_pham" type="text" placeholder="Tên sản phẩm"
                            class="form-control mt-2">
                        <label class="mt-2"><b>Danh mục</b></label>
                        <input v-model="create.danh_muc" type="text" placeholder="Tên danh mục"
                            class="form-control mt-2">
                        <label class="mt-2"><b>Giá bán</b></label>
                        <input v-model="create.gia_ban" type="text" placeholder="Giá bán" class="form-control mt-2">
                        <label class="mt-2"><b>Hình ảnh</b></label>
                        <input v-model="create.hinh_anh" type="img" placeholder="Tên sản phẩm"
                            class="form-control mt-2">
                        <label class="mt-2"><b>Mô tả</b></label>
                        <textarea v-model="create.mo_ta" class="form-control mt-2" cols="30" rows="4"></textarea>
                        <label class="mt-2">Tình trạng</label>
                        <select v-model="create.tinh_trang" class="form-control mt-2">
                            <option value="1">Dưới hoặc bằng50</option>
                            <option value="0">Trên 50kg</option>
                        </select>
                    </div>
                    <div class="card-footer text-end">
                        <button v-on:click="themMoiDanhSachSP()" class="btn btn-primary">Thêm mới sản phẩm</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh Sách Sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th class="align-middler">#</th>
                                        <th class="align-middler">Tên Sản phẩm</th>
                                        <th class="align-middler">Danh mục</th>
                                        <th class="align-middler">Giá bán</th>
                                        <th class="align-middler">Hình ảnh</th>
                                        <th class="align-middler">Mô tả</th>
                                        <th class="align-middler">Tình trạng</th>
                                        <th class="align-middler">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center align-middler">
                                    <template v-for="(value, index) in list" :key="index">
                                        <tr>
                                            <th>{{ index + 1 }}</th>
                                            <td>{{ value.ten_san_pham }}</td>
                                            <td>{{ value.danh_muc }}</td>
                                            <td>{{ value.gia_ban }}</td>
                                            <td><img :src="value.hinh_anh" alt="" class="img-fluid"></td>
                                            <td><i class="fa-brands fa-font-awesome"></i></td>
                                            <td>
                                                <button v-if="value.tinh_trang" class="btn btn-info me-2">Dưới 50kg</button>
                                                <button v-else class="btn btn-warning">Trên 50kg</button>
                                            </td>
                                            <td>
                                                <button v-on:click="Object.assign(del_san_pham, value)"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    class="btn btn-info me-2">Xóa</button>
                                                <button class="btn btn-warning">Cập nhật</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            notificationList: [],
            create: {
                "ten_san_pham": "",
                "danh_muc": "",
                "gia_ban": "",
                "hinh_anh": "",
                "mo_ta": "",
                "tinh_trang": ""
            },
            list: []
        }
    },
    mounted() {
        this.loadDanhSachSP();
        this.$toast.success(`Chào mừng bạn <br> đến với trang sản phẩm của chúng tôi`);
   },
    methods: {
        
        themMoiDanhSachSP() {
            axios
                .post("http://127.0.0.1:8000/api/admin/danh-sach-san-pham/create", this.create)
                .then((res) => {
                    this.loadDanhSachSP();
                    this.create = {
                    };
                });

        },
        loadDanhSachSP(){
            axios
                .get("http://127.0.0.1:8000/api/admin/danh-sach-san-pham/data")
                .then((res)=>{
                    this.list=res.data.data;
                })
        },

    },
}
</script>
<style></style>