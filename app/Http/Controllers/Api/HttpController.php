<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Debugbar;

class HttpController extends Controller
{
    public function getTest()
    {
        $response = Http::get('https://www.api-football.com/demo/v2/leagues/country/World/2019/players');
        // dd($response->body());
        Debugbar::info($response->body());
        return $response;
    }
}
