<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        // $categories = User::findOrFail(23)->categories->toArray();
        // return $categories[0]['slug'];


        //  uso eager loading per le categories
        // NB il primo metodo che si chiama deve sempre essere STATICO (::), poi uso la freccia ->
        $user = User::orderBy('id', 'desc')->with('categories')->get();
        $userWithId = User::where('id', '=', 10)->get();
        $userLike = User::where('email', 'like', '%' . 'anna' . '%')->get();

        return response()->json([
            "user" => '',
            "userWithId" => $userWithId,
            "userLike" => $userLike,
        ]);
    }
}
