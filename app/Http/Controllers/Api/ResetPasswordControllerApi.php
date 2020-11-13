<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


/**
 * ResetPasswordControllerApi is a custom Controller for vue api
 */
class ResetPasswordControllerApi extends Controller
{

    // la request custom ha dei campi fissi che gestisco dentro a essa, in questo caso ResetPasswordRequest
    // sono i fields della post.
    public function reset(ResetPasswordRequest $request)
    {

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }


    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();
        //        event(new PasswordReset($user));
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json([
            "message" => 'Password reset succeeded',
            "response" => $response
        ], 200);
    }


    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            "message" => 'Password reset failed',
            "response" => $response
        ], 500);
    }
}
