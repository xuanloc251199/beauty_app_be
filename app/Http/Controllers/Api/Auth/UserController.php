<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(Request $request) {
        $user = Auth::user();
        
        // Load thông tin chi tiết của user nếu có
        $user->load('userDetails');
        
        return response()->json($user);
    }
    
}
