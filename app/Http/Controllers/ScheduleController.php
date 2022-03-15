<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
//use App\Models\Event;
use App\Models\EventBookingSchedule;
use App\Models\Slotbooking;
use Illuminate\Support\Facades\Validator;
use Date;
use Spatie\GoogleCalendar\Event;
class ScheduleController extends Controller
{

    public function index(Request $request){

        $userid=auth()->id();
        $getSchedule =Schedule::where('user_id',$userid)->orderBy('is_default','asc')->get();
         $events = Event::get();
         return response()->json([
            "success" => true,
            "data" => $getSchedule
        ], 201);

//          $event = new Event();
// $event->name = 'A new event';
// $event->description = 'Event description';
// $event->startDateTime = Carbon::now();
// $event->endDateTime = Carbon::now()->addHour();

// $calendar = GoogleCalendarFactory::createForCalendarId('jitmaity2203@gmail.com');
// $calendar->insertEvent($event);





//dd($events);
        //create a new event
        // $event = new Event;

        // $event->name = 'A new event';
        // $event->description = 'Event description';
        // $event->startDateTime = Carbon\Carbon::now();
        // $event->endDateTime = Carbon\Carbon::now()->addHour();
        // $event->addAttendee([
        // 'email' => 'palashnayak1997@gmail.com',
        // 'name' => 'Palash Nayak',
        // 'comment' => 'Lorum ipsum',
        // ]);
        // $event->addAttendee(['email' => 'jitmaity2203@gmail.com']);

        // $event->save();

        // Event::create([
        // 'name' => 'A new event',
        // 'startDateTime' => Carbon\Carbon::now(),
        // 'endDateTime' => Carbon\Carbon::now()->addHour(),
        // ]);




    }

    public function getEventDetails(Request $request){

        $userid=auth()->id();

        if($userid){

            $user = User::find($userid);

            $getSchedule =Event::where('id',$request->id)->with(['eventschedule'])->first();
            $getSchedule->userdetails = $user;

         return response()->json([
            "success" => true,
            "data" => $getSchedule
        ], 201);

        }else{

             return response()->json([
                'success' => false,
                'error'=>'Something went wrong'
            ], 422);

        }
        

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

             return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);

           

        }else{

           $schedule = Schedule::where('id',$request->schedule_id)->where('user_id',auth()->id())->first();

            //$schedule->name = 'test';
            $schedule->timezone = 'UTC';
            $schedule->user_id = auth()->id();
            $schedule->availability = json_encode($request->availability);

            $schedule->save();

             return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);
          

        }


        if($check->is_default==0){


                 $checkCustomeSchedule=EventBookingSchedule::where('user_id',auth()->id())->first();

        if($checkCustomeSchedule){

            EventBookingSchedule::where('user_id',auth()->id())->update([

                'availabledates' => json_encode($request->availability)

            ]);
            
            // $checkCustomeSchedule->availabledates = json_encode($request->availability);

            // $checkCustomeSchedule->save();

             return response()->json([
            "success" => true,
            "data" => $schedule
        ], 201);

        }

        }

       
      
        
       
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

    public function setDefault(Request $request){

        $userid=auth()->id();

        Schedule::query()->update(['is_default'=>'1']);

        Schedule::where('id',$request->id)->update(['is_default'=>'0']);
        $getSchedule =Schedule::where('user_id',$userid)->orderBy('is_default','asc')->get();

             return response()->json([
                    "success" => true,
                    "data" => $getSchedule
                    ], 200);  


    }

    public function saveSlot(Request $request){

         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'description' => 'required',
            'calendar_type' => 'required',
            'reminder' => 'required_if:calendar_type,application_calendar',
            'reminder_notification' => 'required_if:calendar_type,application_calendar',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                $validator->errors()
            ], 422);
        }else{

            $slotBooking = new Slotbooking;
            //$allData = [
                $slotBooking->name =$request->name;
                $slotBooking->email =$request->email;
                $slotBooking->description=$request->description;
                $slotBooking->user_id=$request->userId;
                $slotBooking->event_id=$request->eventid;
                $slotBooking->confirmdate=$request->date;
                $slotBooking->timezone=$request->timeZone;
                $slotBooking->slot=$request->slot;
                $slotBooking->calendar_type=$request->calendar_type;
                $slotBooking->reminder_before=json_encode($request->reminder);
                $slotBooking->reminder_notify_by=json_encode($request->reminder_notification);
                $slotBooking->save();

            //];

           // $insertSlot = Slotbooking::insert($allData);

                $details = [
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'description'=>$request->description,
                    'timezone'=>$request->timeZone,
                    'slot'=>$request->slot,
                    'eventname'=>$request->eventname,
                    'newdateval'=>$request->newdateval


                ];

                //\Mail::to($request->email)->send(new \App\Mail\SlotBookingMail($details));

             return response()->json([
                    "success" => true,
                    "data" => $slotBooking
                    ], 200);


        }

    }

    public function getScheduledEvents(Request $request){

        $userid=auth()->id();
        $arrayList=[];
        $i=0;

        if($userid){

            if (isset($request->startdate)) {
                

                    $slotbooking = Slotbooking::where('user_id',$userid)->groupBy('confirmdate')->get();

                    foreach ($slotbooking as $key => $value) {

                    // $getDetails = Slotbooking::select('slotbookings.*','users.*','events.*')
                    //     ->join('users','slotbookings.user_id','=','users.id')
                    //     ->join('events','slotbookings.event_id','=','events.id')
                    //     ->where('slotbookings.user_id','=',$userid)
                    //     ->where('slotbookings.confirmdate','=',$value['confirmdate'])
                    //     ->get();

                        if(strtotime($value['confirmdate'])>=strtotime($request->startdate) &&  strtotime($value['confirmdate'])<=strtotime($request->enddate)){


                                $getDetails = Slotbooking::with(['user','event'])->where('slotbookings.user_id','=',$userid)->where('slotbookings.confirmdate','=',$value['confirmdate'])->get();


                                $arrayList[$value['confirmdate']] = $getDetails;
                                $i++;

                        }

                   
                    // code...
                    }

                    return response()->json([
                    "success" => true,
                    'message'=>$request->startdate,
                    "data" => $arrayList
                    ], 200);
            }else if(isset($request->type) && $request->type=='upcoming'){


                  $slotbooking = Slotbooking::where('user_id',$userid)->where('confirmdate','>',date('Y-m-d'))->groupBy('confirmdate')->get();

                    foreach ($slotbooking as $key => $value) {

                    // $getDetails = Slotbooking::select('slotbookings.*','users.*','events.*')
                    //     ->join('users','slotbookings.user_id','=','users.id')
                    //     ->join('events','slotbookings.event_id','=','events.id')
                    //     ->where('slotbookings.user_id','=',$userid)
                    //     ->where('slotbookings.confirmdate','=',$value['confirmdate'])
                    //     ->get();



                    $getDetails = Slotbooking::with(['user','event'])->where('slotbookings.user_id','=',$userid)->where('slotbookings.confirmdate','=',$value['confirmdate'])->get();


                    $arrayList[$value['confirmdate']] = $getDetails;
                    $i++;
                    // code...
                    }

                    return response()->json([
                    "success" => true,
                    'message'=>$request->type,
                    "data" => $arrayList
                    ], 200);


            }else if(isset($request->type) && $request->type=='past'){

                   $slotbooking = Slotbooking::where('user_id',$userid)->where('confirmdate','<',date('Y-m-d'))->groupBy('confirmdate')->get();

                    foreach ($slotbooking as $key => $value) {

                    // $getDetails = Slotbooking::select('slotbookings.*','users.*','events.*')
                    //     ->join('users','slotbookings.user_id','=','users.id')
                    //     ->join('events','slotbookings.event_id','=','events.id')
                    //     ->where('slotbookings.user_id','=',$userid)
                    //     ->where('slotbookings.confirmdate','=',$value['confirmdate'])
                    //     ->get();



                    $getDetails = Slotbooking::with(['user','event'])->where('slotbookings.user_id','=',$userid)->where('slotbookings.confirmdate','=',$value['confirmdate'])->get();


                    $arrayList[$value['confirmdate']] = $getDetails;
                    $i++;
                    // code...
                    }

                    return response()->json([
                    "success" => true,
                    'message'=>$request->type,
                    "data" => $arrayList
                    ], 200);

            }

          

        }else{

             return response()->json([
                'success' => false,
                'errors' =>'Something went wrong'
            ], 422);
        }

      
    }

    function checkSchedule(Request $request){

         $userid=auth()->id();


        $check = Slotbooking::where('user_id',$userid)
                    ->where('event_id',$request->id)
                    ->where('confirmdate',$request->selectdate)
                    ->get();

                    foreach($check as $key=>$value){


                    $getslot = explode('-',$value['confirmdate'])[0];

                    //$date1 = 
                    }



            return response()->json([
            "success" => true,
            "data" => $check
            ], 200);        
    }
}
