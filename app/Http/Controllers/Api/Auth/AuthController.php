<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login method
     */
    
    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->validated());
        if ($token){
            return $this->responseWithToken($token, auth()->user());
        }else{
            return response()->json([
                'status' => 'false',
                'massage' => 'Invalid credentials'
            ], 401);
        }
    }

    /**
     * Registration method
     */
    public function register(RegistrationRequest $registerRequest)
    {
        // $user = User::create($registerRequest->validated());
        $user = User::create([
            'name' => $registerRequest['name'],
            'email' => $registerRequest['email'],
            'password' => bcrypt($registerRequest['password']),
        ]);

        if ($user) {
            // $user->sendEmailVerificationNotification();
            $token = auth()->attempt($registerRequest->only('email', 'password'));
            return $this->responseWithToken($token, $user);
        } else {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while trying to create the user'], 500);
        }
    }

    /**
     * Return JWT access Token
     */

    public function responseWithToken($token, $user){
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'type' => 'bearer,'
        ]);
    }

    /**
     * Email Verification
     */

    public function checkEmailVerification(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $isVerified = !is_null($user->email_verified_at);

        $user->email_verified_at = now();
        $user->verification_token = null; // Clear verification token
        $user->save();

        return response()->json(['isVerified' => $isVerified]);
    }
}
