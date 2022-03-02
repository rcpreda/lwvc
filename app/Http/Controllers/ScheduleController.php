<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\EventBookingSchedule;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{

    public function index(Request $request){

        $userid=auth()->id();
        $getSchedule =Schedule::where('user_id',$userid)->orderBy('id','desc')->first();
         return response()->json([
            "success" => true,
            "data" => $getSchedule
        ], 201);

    }
    public function store(Request $request, Schedule $schedule){
        
        $validator = Validator::make($request->all(), [
            'availability' => 'required|array'
            //'availability' => 'required|json'
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

        $check = Schedule::where('user_id',auth()->id())->first();

        if(!$check){

            $schedule->name = 'test';
            $schedule->timezone = 'UTC';
            $schedule->user_id = auth()->id();
            $schedule->availability = json_encode($request->availability);

            $schedule->save();

           

        }else{

           $schedule = Schedule::where('user_id',auth()->id())->first();

            $schedule->name = 'test';
            $schedule->timezone = 'UTC';
            $schedule->user_id = auth()->id();
            $schedule->availability = json_encode($request->availability);

            $schedule->save();
          

        }

        $checkCustomeSchedule=EventBookingSchedule::where('user_id',auth()->id())->first();

        if($checkCustomeSchedule){

            EventBookingSchedule::where('user_id',auth()->id())->update([

                'availabledates' => json_encode($request->availability)

            ]);
            
            // $checkCustomeSchedule->availabledates = json_encode($request->availability);

            // $checkCustomeSchedule->save();

        }
      
        
        return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);
    }
}
