<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GetUserRole extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function __invoke(Request $request)
    {
        if (Auth::user()) {
            $roleData = Auth::user()->roles;
            if (count($roleData) !== 0) {
                $role = $roleData[0]["slug"];
                return response()->json(
                    [
                        "role" => $role
                    ]
                );
            } else {
                return response()->json(
                    [
                        "role" => "",
                        "error" => "user without role"
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    "role" => "",
                    "error" => "not authenticated"
                ]
            );
        }
    }
}
