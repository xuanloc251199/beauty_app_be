<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function verify(Request $request)
    {
        Log::info("Verifying user: {$request['id']}");
        // Xác định người dùng từ $request->route('id')
        $userID = $request['id'];
        $user = User::findOrFail($userID);

        // Kiểm tra xem link xác thực có chứa token đúng không
        $date = date("Y-m-d g:i:s", strtotime($request['expires']));
        $timestamp = strtotime($date);
        if ( ! hash_equals((string) $timestamp, (string) $request['expires'])
            || ! hash_equals((string) $request['hash'], sha1($user->getEmailForVerification()))) {
            // Thông báo lỗi hoặc xử lý nếu link không hợp lệ
            return response()->json(["msg" => "Link xác thực không hợp lệ."], 400);
        }

        // Xác thực email nếu link hợp lệ
        if ($user->markEmailAsVerified())
            event(new Verified($user));

        // Chuyển hướng sau khi xác thực thành công
        return redirect($this->redirectPath());
    }
}
