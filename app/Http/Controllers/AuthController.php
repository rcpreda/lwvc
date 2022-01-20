<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function signupForm(){
        if(auth()->check()){
            return redirect()->route('chat');
        }
        return view('Auth.signup');
    }

    public function loginForm(){
        if(auth()->check()){
            return redirect()->route('chat');
        }
        return view('Auth.login');
    }

    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('/signup')->withErrors($validator)->withInput();
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator)->withInput();
        }

        $success = auth()->attempt([
            'email' => request('email'),
            'password' => request('password')
        ], request()->has('remember'));

        if($success){
            $request->session()->regenerate();
            return redirect()->route('chat');
        }

        return back()->withInput()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        auth()->logout();
        
        return response()->json([
            "success" => true
        ], 200);
    }
}
