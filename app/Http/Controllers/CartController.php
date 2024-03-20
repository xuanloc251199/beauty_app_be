<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Phương thức thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request) {
        // Xác thực người dùng từ token
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    
        // Kiểm tra sản phẩm tồn tại
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    
        // Thêm sản phẩm vào giỏ hàng
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $productId;
        $cart->quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không được cung cấp
        $cart->save();
    
        return response()->json(['message' => 'Product added to cart successfully.']);
    }

    public function removeFromCart(Request $request) {
        // Xác thực người dùng từ token
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    
        // Kiểm tra sản phẩm tồn tại trong giỏ hàng
        $productId = $request->input('product_id');
        $quantityToRemove = $request->input('quantity', 1); // Số lượng sản phẩm cần giảm, mặc định là 1 nếu không được cung cấp
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Product not found in cart.'], 404);
        }
    
        // Giảm số lượng của sản phẩm, hoặc xoá nếu số lượng nhỏ hơn hoặc bằng 0
        $newQuantity = $cartItem->quantity - $quantityToRemove;
        if ($newQuantity > 0) {
            // Cập nhật số lượng mới nếu lớn hơn 0
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            return response()->json(['message' => 'The quantity of the product has been updated successfully.']);
        } else {
            // Xoá sản phẩm khỏi giỏ hàng nếu số lượng mới nhỏ hơn hoặc bằng 0
            $cartItem->delete();
            return response()->json(['message' => 'Product has been removed from the cart.']);
        }
    }
    

    public function getItemCount(Request $request)
    {
        $userId = Auth::id(); // Lấy ID của người dùng đã xác thực

        $count = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json([
            'success' => true,
            'item_count' => $count
        ]);
    }

    public function showCartByUser()
    {
        $user = Auth::user();
        // Lấy giỏ hàng của người dùng và nhóm theo product_id
        $cartItems = Cart::where('user_id', $user->id)
                        ->selectRaw('product_id, sum(quantity) as total_quantity')
                        ->groupBy('product_id')
                        ->with('product')
                        ->get();

        $cartItemsDetailed = $cartItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'star' => $item->product->star,
                'quantity' => $item->total_quantity,
                'price' => $item->product->price,
                'total_price' => $item->total_quantity * $item->product->price,
                'featured_image' => $item->product->featured_image,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $cartItemsDetailed
        ]);
    }
}
