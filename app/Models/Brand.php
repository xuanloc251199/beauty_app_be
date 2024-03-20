<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Định nghĩa tên bảng nếu tên bảng không phải là số nhiều của tên model
    protected $table = 'brand';

    // Định nghĩa các trường có thể được mass assignable
    protected $fillable = ['name'];

    // Nếu bạn không muốn sử dụng các timestamps (created_at và updated_at)
    public $timestamps = false;
}
