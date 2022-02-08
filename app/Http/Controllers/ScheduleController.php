<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function store(Request $request, Schedule $schedule){
        
        $validator = Validator::make($request->all(), [
            'availability' => 'required|array',
            'availability' => 'required|json'
        ]);

        // return gettype($request->availability);
        // return 'no';

        // return $request->availability;

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                $validator->errors()
            ], 422);
        }

        if(!$schedule){
            $schedule = new Schedule;
        }
        $schedule->name = 'test';
        $schedule->timezone = 'UTC';
        $schedule->user_id = auth()->id();
        $schedule->availability = json_encode($request->availability);

        $schedule->save();
        
        return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);
    }
}
