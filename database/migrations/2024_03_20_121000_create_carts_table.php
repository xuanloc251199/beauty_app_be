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
        Schema::create('carts', function (Blueprint $table) {
            $table->integer('id', true); // Tạo cột id kiểu integer và tự tăng
            $table->unsignedBigInteger('user_id');
            $table->integer('product_id');
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->timestamps(); // Cột timestamps mặc định (created_at và updated_at)

            // Khai báo khóa ngoại (foreign key) nếu cần
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
