<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(Request $request)
    {
        // Lấy tất cả sản phẩm
        $category = Category::all();
        
        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($category);
    }
}
