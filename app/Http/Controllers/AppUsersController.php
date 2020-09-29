<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AppUsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $users = DB::table('users')->paginate(10);
        return view('users')->with(['users' => $users]);
    }

    public function create(Request $request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->id_rol = $request->id_rol;
        $user->save();
        //Check if user got saved
        if ($user->save())
        {
            return response()->json($user);
        }
    }
}
