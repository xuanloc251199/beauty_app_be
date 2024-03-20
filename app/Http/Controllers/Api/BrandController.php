<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function brand(Request $request)
    {
        // Lấy tất cả sản phẩm
        $brand = Brand::all();
        
        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($brand);
    }
}
