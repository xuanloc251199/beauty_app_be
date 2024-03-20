<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        // Lấy tất cả sản phẩm
        $products = Product::all();
        
        // Trả về dữ liệu sản phẩm dưới dạng JSON
        return response()->json($products);
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        return response()->json($products);
    }

    public function getProductsById($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
