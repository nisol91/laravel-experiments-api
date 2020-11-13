<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * ForgotPasswordControllerApi is a custom Controller for vue api
 */
class ForgotPasswordControllerApi extends Controller
{
    // ForgotPasswordRequest è una request custom (php artisan make:request ForgotPasswordRequest)
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        // di solito laravel ritorna una view per le sue view
        // noi dobbiamo sempre invece pensare di ritornare un responso json per la nostra
        // frontend app in vue o altri framework.
        return response()->json([
            'message' => 'Email sent',
            'response' => $response
        ], 200);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Failed to send mail',
            'response' => $response
        ], 500);
    }
}
