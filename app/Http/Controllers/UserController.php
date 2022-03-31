<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

            $rules = array(
            'file' => 'mimes:jpeg,jpg,png,gif|max:5120' // max 5mb
            );

             $validator = Validator::make($request->all(), $rules);

              if ($validator->fails()){

                    return response()->json([
                    "success" => false,
                    "message" =>'Upload a jpeg,jpg,gif or png image with in 5mb.',
                    "data" =>  '',
                    ], 200);

              }else{

                    $uploadedFile = $request->file('file');
                    $filename = time().$uploadedFile->getClientOriginalName();

                    Storage::disk('public')->putFileAs(
                    'profileimage',
                    $uploadedFile,
                    $filename
                    );

                    $data['profile_image'] = $filename;
              }

           
        }

        $data['name'] = $request->name;
        $data['welcome_message'] = $request->welcomemessage;

        User::where('id',$userid)->update($data);

        $user = User::find($userid);
        

        return response()->json([
            "success" => true,
            "message" => 'Update Successfully',
            "data" =>  $user,
        ], 200);
    }
}
