<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Class AppUsersController
 * @package App\Http\Controllers
 */
class AppUsersController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(){
        $users = DB::table('users')->paginate(10);
        return view('users')->with(['users' => $users]);
    }

    public function create(Request $request){
        try {
            $data = $request->all();
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->id_rol = $data['id_rol'];
            $user->save();
            return response()->json($user);
        } catch (Exception $exception) {
            return response()->json('error');
        }
    }
}
