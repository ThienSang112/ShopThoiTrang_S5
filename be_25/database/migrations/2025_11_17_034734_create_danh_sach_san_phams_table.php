<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_sach_san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ten_san_pham');
            $table->text('mo_ta');
            $table->string('danh_muc');
            $table->decimal('gia_ban');
            $table->string('hinh_anh');
            $table->integer('tinh_trang');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_sach_san_phams');
    }
};
