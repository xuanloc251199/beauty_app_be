<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Bảo vệ $table chỉ định tên bảng trong cơ sở dữ liệu
    protected $table = 'comment';

    protected $fillable = [
        'product_id',
        'email',
        'fullname',
        'star',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
