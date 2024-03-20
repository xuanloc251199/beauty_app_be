<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
{
    public function update(Request $request) {
        $user = Auth::user();
        $userDetails = $user->userDetails();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone_number' => 'required',
            'avatar' => 'required', 
        ]);

        // Cập nhật tên người dùng
        $user->name = $request->name;
        $user->save();
    
        $userDetails->updateOrCreate(
            ['user_id' => $user->id],
            ['address' => $request->address, 'phone_number' => $request->phone_number, 'avatar' => $request->avatar]
        );
    
        return response()->json(['message' => 'User details updated successfully!']);
    }
    
}
