<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckIfUserEmailVerified extends Controller
{

    // e' un alternativa al middleware verified. Questa classe custom NON viene utilizzata per ora.
    /**
     * checkEmailVerified
     *
     * @return Bool
     */
    public function checkEmailVerified(Request $request)
    {
        $user = User::where('email', $request['email']);


        if ($user['email_verified_at'] !== null) {
            return response()->json([
                "message" => "Email is verified!",
                "success" => true,
            ], 200);
        }
        return response()->json([
            "message" => "Email is not verified!",
            "success" => false,
        ], 403);
    }
}
