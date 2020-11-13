<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword(Request $request)
    {
        // dd($request->all());

        $user = User::findOrFail(Auth::id());

        // dd($user);

        // per far si che funzioni il |confirmed mi basta che in input nella request dal frontend mandi anche
        // password_confirmed, ma qua non deve esserci nella validation
        $requestValidatedData = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|confirmed',
        ]);

        if (Hash::check($requestValidatedData['oldPassword'], $user->password)) {
            $user->password = Hash::make($requestValidatedData['newPassword']);
        } else {
            return response()->json(
                // questo è un custom response error fatto da me
                [

                    "errors" => [
                        "oldPassword" => ["message" => "the old password does not match"]
                    ]

                ],
                420
            );
        }


        if ($user->save()) {

            return response()->json([
                "status" => true
            ]);
        } else {
            return response()->json([
                "status" => false
            ]);
        }
    }

    public function changeDetails(Request $request)
    {

        // dd($request->all());

        $user = User::findOrFail(Auth::id());

        // dd($user);

        $requestValidatedData = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $user->name = $requestValidatedData['name'];

        if ($user->save()) {

            return response()->json([
                "status" => true
            ]);
        } else {
            return response()->json([
                "status" => false
            ]);
        }
    }
}
