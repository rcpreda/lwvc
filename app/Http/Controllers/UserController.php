<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function user(Request $request){
        return response()->json([
            "success" => true,
            "data" => $request->user(),
        ], 200);
    }

    public function index(){
        $users = User::where('id', '!=', auth()->id())->get();
        return response()->json([
            "success" => true,
            "data" => $users,
        ], 200);
    }
}
