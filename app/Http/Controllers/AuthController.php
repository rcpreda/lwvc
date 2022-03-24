<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use DB;

class AuthController extends Controller
{
    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                $validator->errors()
            ], 422);
        }



        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username = strtolower(str_replace(" ", "", $request->name)).User::max('id').mt_rand(1111,9999);
        // $user->slug = Str::slug($request->name);

        $user->save();

        return response()->json([
            "success" => true
        ], 201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                 $validator->errors()
            ], 422);
        }

        $success = auth()->attempt([
            'email' => request('email'),
            'password' => request('password')
        ], request()->has('remember'));

        if($success){

             $username = strtolower(str_replace(" ", "", auth()->user()->name)).User::max('id').mt_rand(1111,9999);

            if(auth()->user()->username== null){

                DB::table('users')->where('id',auth()->user()->id)->update([

                    'username' => $username

                ]);

                
            }

            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'data' => auth()->user()
            ], 200);




        }

        return response()->json([
            'success' => false,
            'error' => 'Provided credentials are wrong!'
        ], 422);
    }

    public function logout(Request $request){
        auth()->logout();
        
        return response()->json([
            "success" => true
        ], 200);
    }
}
