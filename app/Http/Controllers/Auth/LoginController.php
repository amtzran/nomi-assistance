<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
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
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        $email = $request->get('username');
        $password = $request->get('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $idUser = User::where('email', $email)->first();
            $company = DB::table('empresas')->where('id', $idUser->id_empresa)->first();
            $status = $company->status;
            if ($status === 1) {
                $loginResponse = [
                    'loginResponse' => 1,
                    'user_name' => $idUser->name,
                    'email' => $idUser->email,
                    'user_id' => $idUser->id,
                    'company_id' => $idUser->id_empresa,
                    'company' => $company->nombre
                ];
            } else $loginResponse = ['loginResponse' => 2];

            $collection = collect($loginResponse);
            return response()->json($collection);
        }
        else
        {
            $loginResponse = ['loginResponse' => 0];
            $collection = collect($loginResponse);
            return response()->json($collection);
        }
    }
}
