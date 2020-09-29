<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Valida los datos de intento de sesión desde app para generar el login.
     */
    public function authenticate($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $idUser = DB::table('users')->where('email', $email)->first();
            $loginResponse = ['loginResponse' => 1, 'name' => $idUser->name, 'email' => $idUser->email, 'id_rol' => $idUser->id_rol];
            $collection = collect($loginResponse);
            echo $collection->toJson();
        }
        else
        {
            $loginResponse = ['loginResponse' => 0];
            $collection = collect($loginResponse);
            echo $collection->toJson();
        }
    }
}
