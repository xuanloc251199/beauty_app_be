<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Bảo vệ $table chỉ định tên bảng trong cơ sở dữ liệu
    protected $table = 'product';

    // $fillable chỉ định các trường có thể được mass assignment
    protected $fillable = [
        'barcode',
        'sku',
        'name',
        'price',
        'discount_percentage',
        'discount_from_date',
        'discount_to_date',
        'featured_image',
        'inventory_qty',
        'category_id',
        'brand_id',
        'description',
        'star',
        'featured'
    ];

    //Khai báo mối quan hệ với Category và Brand
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}
}
