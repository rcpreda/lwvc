<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

    public function updateProfile(Request $request){

        $userid = auth()->user()->id;
        $data = array();

        if($request->has('file')){

            $uploadedFile = $request->file('file');
            $filename = time().$uploadedFile->getClientOriginalName();

            Storage::disk('local')->putFileAs(
            'files',
            $uploadedFile,
            $filename
            );

            $data['profile_image'] = $filename;
        }

        $data['name'] = $request->name;

        User::where('id',$userid)->update($data);

        $user = User::find($userid);
        

        return response()->json([
            "success" => true,
            "data" =>  $user,
        ], 200);
    }
}
