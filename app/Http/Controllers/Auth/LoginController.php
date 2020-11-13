<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
    Ho copiato qui questo metodo dal trait AuthenticatesUsers,
    cosi lo posso sovrascrivere: di fatto se sono autenticato allora mi ritorna un 204
    (questo per via del fatto che sto usando laravel con vue)
    */

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // mi da un ritorno solo se la chiamata e di tipo ajax da javascript(vue)
        // e il ritorno dell endpoint /login


        //  creo access token per chiamate api (cioè solo se loggato)
        $token = $user->createToken('token-name');

        if ($request->isXmlHttpRequest()) {
            return [
                "response" => response(null, 204),
                "access_token" => $token->plainTextToken
            ];
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // mi da un ritorno solo se la chiamata e di tipo ajax da javascript(vue)
        // e il ritorno dell endpoint /logout

        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }
}
