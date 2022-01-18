<?php

namespace App\Http\Controllers;

use App\Models\Signal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SignalController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = auth()->user();

        if($user->signal()->exists()){
            $signal = $user->signal;
        } else{
            $signal = new Signal;
        }
        $signal->data = json_encode($request->data, true);
        $user->signal()->save($signal);

        return response()->json([
            "signal" => $signal,
            "success" => true
        ], 201);
    }

    public function show(Signal $signal){
        $data = Signal::with('user')->find($signal);
        return response()->json([
            "data" => $data[0],
            "success" => true,
        ], 200);
    }
}
