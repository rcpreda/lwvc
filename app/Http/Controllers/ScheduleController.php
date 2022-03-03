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
        $getSchedule =Schedule::where('user_id',$userid)->orderBy('id','asc')->get();
         return response()->json([
            "success" => true,
            "data" => $getSchedule
        ], 201);

    }

     public function getIndividualData(Request $request,$id){

        $userid=auth()->id();
        $getSchedule =Schedule::where('id',$id)->first();
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

        $check = Schedule::where('id',$request->schedule_id)->where('user_id',auth()->id())->first();

        if(!$check){

            $schedule->name = 'test';
            $schedule->timezone = 'UTC';
            $schedule->user_id = auth()->id();
            $schedule->availability = json_encode($request->availability);

            $schedule->save();

           

        }else{

           $schedule = Schedule::where('id',$request->schedule_id)->where('user_id',auth()->id())->first();

            //$schedule->name = 'test';
            $schedule->timezone = 'UTC';
            $schedule->user_id = auth()->id();
            $schedule->availability = json_encode($request->availability);

            $schedule->save();
          

        }


        if($check->is_default==0){


                 $checkCustomeSchedule=EventBookingSchedule::where('user_id',auth()->id())->first();

        if($checkCustomeSchedule){

            EventBookingSchedule::where('user_id',auth()->id())->update([

                'availabledates' => json_encode($request->availability)

            ]);
            
            // $checkCustomeSchedule->availabledates = json_encode($request->availability);

            // $checkCustomeSchedule->save();

        }

        }

       
      
        
        return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);
    }

    public function update(Request $request){

         $userid=auth()->id();

        if($request->type=='edit'){


         $check = Schedule::where('id',$request->scheduleid)->where('user_id',$userid)->first();

         if($check->name == $request->schedulename){

                return response()->json([
                "success" => false,

                ], 422);

         }else{

            $check->name = $request->schedulename;
            $check->save();

            return response()->json([
            "success" => true,
            "data" => $check
        ], 201);

         }

        }else{

                 $check = Schedule::where('user_id',$userid)->where('is_default',0)->first();

                 if($check){

                    $newSchedule = new Schedule;

                    $newSchedule->user_id = $check->user_id;
                    $newSchedule->is_default = '1';
                    $newSchedule->name = $request->schedulename;
                    $newSchedule->timezone = $check->timezone;
                    $newSchedule->availability = $check->availability;
                    $newSchedule->save();


                    return response()->json([
                    "success" => true,
                    "data" => $newSchedule
                    ], 201);


                 }else{


                    return response()->json([
                    "success" => false,

                    ], 422);

                 }


        }         

         


         
    }

    public function delete(Request $request){

        $check = Schedule::where('id',$request->id)->first();

        if($check){

            Schedule::where('id',$request->id)->delete();
             return response()->json([
                    "success" => true,
                    "data" => $request->all()
                    ], 200);            
        }else{

             return response()->json([
                    "success" => false,

                    ], 422);
        }


    }
}
