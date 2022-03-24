<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Event;
use App\Models\EventBookingSchedule;
use App\Models\Slotbooking;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Date;
use DateTime;
use DateInterval;
use DateTimeZone;
class ScheduleController extends Controller
{

    protected $client;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setSubject('abc.com');

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }

    public function check(){

         session_start();

         $url = env('APP_BACKEND_URL');

         $datetime='';



          // return response()->json([
          //   "success" => true,
          //   "message" =>"callback",
          //   "data" => $this->oauth()
          //   ], 201);

         $requesturl =  json_decode(file_get_contents(public_path('token.json')));;
         $checktime = $requesturl->expires_in;

        // $datetime = new DateTime('2010-12-30 23:21:46');

        // $datetime->format(DateTime::ATOM);


         if(isset($requesturl) && $requesturl->access_token!=''){

            $this->client->setAccessToken(json_encode($requesturl));

            $datetime = $this->client->isAccessTokenExpired();

            if($this->client->isAccessTokenExpired()){

                if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                }else{

                return response()->json([
                "success" => true,
                "message" =>"callback",
                "data" => $this->oauth()
                ], 201);

                }
            }

            
        

             return response()->json([
            "success" => true,
            "message"=>"getdetails",
            "data" => $url 
            ], 201); 
         }else{

             return response()->json([
            "success" => true,
            "message" =>"callback",
            "data" => $this->oauth()
            ], 201);

         }
        // if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        //     $this->client->setAccessToken($_SESSION['access_token']);
        //     $service = new Google_Service_Calendar($this->client);

        //     $calendarId = 'primary';

        //     $results = $service->events->listEvents($calendarId);
        //     // return $results->getItems();

        //     return response()->json([
        //     "success" => true,
        //     "message"=>"getdetails",
        //     "data" => $results->getItems()
        //     ], 201);

        //     //echo "ok2";

        // } else {

        //     //$this->oauth

        //     return response()->json([
        //     "success" => true,
        //     "message" =>"callback",
        //     "data" => $this->oauth()
        //     ], 201);
        //     //echo "ok1";
        //     // return redirect()->route('oauthCallback');
        // }
    }

      public function oauth()
    {
        // echo "in";
        // session_start();
        $requesturl = request()->getHttpHost();
        $rurl = env('APP_BACKEND_URL').'/'.'api/oauth';
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return array('type'=>'reload','url'=>$filtered_url);

           // echo $filtered_url;
        } else {

            session_start();
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();

            // $data = $_SESSION['access_token'];
            // $expire1 = 3600 + $data['expires_in'];

            // $data['expires_in'] = $expire1;
            $this->client->setAccessToken($_SESSION['access_token']);
             // $calendarId = 'primary';

             file_put_contents(public_path('token.json'), json_encode($_SESSION['access_token']));
             $redirecturl = $rurl = env('APP_FRONT_URL').'/'.'confirm/event';
            return redirect($redirecturl);
            // $results = $service->events->listEvents($calendarId);
            //$this->check();
            // return $results->getItems();
             //return array('type'=>'component','url'=>$results->getItems());

            //$this->client->setAccessToken($_SESSION['access_token']);
            // $service = new Google_Service_Calendar($this->client);

            // $calendarId = 'primary';

            // $results = $service->events->listEvents($calendarId);
            // // return $results->getItems();

            // return response()->json([
            // "success" => true,
            // "message"=>"getdetails",
            // "data" => array('type'=>'component','data'=>$results->getItems())
            // ], 201);
            // return array('type'=>'component','url'=>'');
            // return "http://localhost:3000/api/oauth";
        }
    }

    public function saveSlot(Request $request){

        session_start();

        if($request->calendar_type=='google_calendar'){

            $startdate = $request->date.' '.explode('-',$request->slot)[0];
            $enddate = $request->date.' '.explode('-',$request->slot)[1];

            $date1 = new DateTime($startdate);
           $date1->setTimezone(new DateTimeZone('UTC'));
            $newdate1 = $date1->format('Y-m-d H:i:s');

            $date2 = new DateTime($enddate);
           $date2->setTimezone(new DateTimeZone('UTC'));
             $newdate2 = $date2->format('Y-m-d H:i:s');


        // $startDateTime = date('Y-m-d h:i:s', strtotime($startdate));
        // $endDateTime = date('Y-m-d h:i:s', strtotime($enddate));

            $startDateTime = date(DATE_ISO8601, strtotime($newdate1));
        $endDateTime = date(DATE_ISO8601, strtotime($newdate2));
        $requesturl =  json_decode(file_get_contents(public_path('token.json')));
        if (isset($requesturl) && $requesturl->access_token!='') {
            $this->client->setAccessToken(json_encode($requesturl));

             if($this->client->isAccessTokenExpired()){
                
                // if ($this->client->getRefreshToken()) {
                // $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                // }else{

                        $requesturl = request()->getHttpHost();
                        $rurl = env('APP_BACKEND_URL').'/'.'api/oauth';
                        $this->client->setRedirectUri($rurl);
                        if (!isset($_GET['code'])) {
                        $auth_url = $this->client->createAuthUrl();
                        $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
                        // return array('type'=>'reload','url'=>$filtered_url);

                        return response()->json([
                        "success" => false,
                        "message" => 'callback',
                        "data" => array('type'=>'reload','url'=>$filtered_url)
                        ], 200);

                }
            
        }




            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $request->eventname,
                'description' => $request->description,
                // 'start' => $startDateTime,
                // 'end' => $endDateTime,
                'start' => ['dateTime' => $startDateTime,'timeZone'=>'UTC'],
                'end' => ['dateTime' => $endDateTime,'timeZone'=>'UTC'],
                'attendees' => array(
                array('email' => $request->email),         
                ),
                'reminders' => ['useDefault' => true],
            ]);
            $results = $service->events->insert($calendarId, $event);
            if (!$results) {

                return response()->json([
                    "success" => false,
                    "message" => 'Something went wrong',
                    "data" => null
                    ], 422);


                // return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            
        } else {

            $requesturl = request()->getHttpHost();
            $rurl = env('APP_BACKEND_URL').'/'.'api/oauth';
            $this->client->setRedirectUri($rurl);
            if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            // return array('type'=>'reload','url'=>$filtered_url);

            return response()->json([
                    "success" => false,
                    "message" => 'callback',
                    "data" => array('type'=>'reload','url'=>$filtered_url)
                    ], 200);
            }

             
            // return response()->json(['status' => 'success', 'message' => 'oauthCallback']);
            //redirect()->route('oauthCallback');
        }

        }
       

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

                  $startdate = $request->date.' '.explode('-',$request->slot)[0];
            $enddate = $request->date.' '.explode('-',$request->slot)[1];

            $date1 = new DateTime($startdate);
            $newdate1 = $date1->format('Y-m-d H:i:s');

            $date2 = new DateTime($enddate);
            $newdate2 = $date2->format('Y-m-d H:i:s');

        $startDateTime = date(DATE_ISO8601, strtotime($newdate1));
        $endDateTime = date(DATE_ISO8601, strtotime($newdate2));

        $startdate = Carbon::now();

               
                 // $newstartdate =date('Y-m-d\TH:i:s', $startdate);

                //\Mail::to($request->email)->send(new \App\Mail\SlotBookingMail($details));

                //return response()->json(['status' => 'success', 'message' => 'Event Created']);
             return response()->json([
                    "success" => true,
                    "data" => $request->date.'-'.$request->slot.'-'.$startdate.'-'.$enddate.'-'.$request->timeZone
                    ], 200);


        }

    }

//     function getClient()
// {
//     $client = new Google_Client();
//     $client->setApplicationName('Web client 1');
//     $client->setScopes(Google_Service_Calendar::CALENDAR);
//     // $client->setAuthConfig('client_secret.json');
//     $client->setAccessType('offline');
//      $client->setSubject('abc.com');
//      $client->setClientSecret('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');

//     $client->setPrompt('select_account consent');

//     // Load previously authorized token from a file, if it exists.
//     // The file token.json stores the user's access and refresh tokens, and is
//     // created automatically when the authorization flow completes for the first
//     // time.
//     $tokenPath = public_path('token.json');

//     echo $tokenPath;
//     if (file_exists($tokenPath)) {
//         $accessToken = json_decode(file_get_contents($tokenPath), true);
//         $client->setAccessToken($accessToken);
//     }

//     // If there is no previous token or it's expired.
//     if ($client->isAccessTokenExpired()) {
//         // Refresh the token if possible, else fetch a new one.
//         if ($client->getRefreshToken()) {
//             $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
//         } else {
//             // Request authorization from the user.
//             $authUrl = $client->createAuthUrl();
//             printf("Open the following link in your browser:\n%s\n", $authUrl);
//             print 'Enter verification code: ';
//             $authCode = trim(fgets(STDIN));

//             // Exchange authorization code for an access token.
//             $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
//             $client->setAccessToken($accessToken);

//             // Check to see if there was an error.
//             if (array_key_exists('error', $accessToken)) {
//                 throw new Exception(join(', ', $accessToken));
//             }
//         }
//         // Save the token to a file.
//         if (!file_exists(dirname($tokenPath))) {
//             mkdir(dirname($tokenPath), 0700, true);
//         }
//         file_put_contents($tokenPath, json_encode($client->getAccessToken()));
//     }
//     return $client;
// }



    public function index(Request $request){

        session_start();
        $userid=auth()->id();
        $getSchedule =Schedule::where('user_id',$userid)->orderBy('is_default','asc')->get();
         //$events = Event::get();
        


//          // Get the API client and construct the service object.
// $client = $this->getClient();
// $service = new Google_Service_Calendar($client);

// // Print the next 10 events on the user's calendar.
// $calendarId = 'primary';
// $optParams = array(
//   'maxResults' => 10,
//   'orderBy' => 'startTime',
//   'singleEvents' => true,
//   'timeMin' => date('c'),
// );
// $results = $service->events->listEvents($calendarId, $optParams);
// $events = $results->getItems();

// if (empty($events)) {
//     print "No upcoming events found.\n";
// } else {
//     print "Upcoming events:\n";
//     foreach ($events as $event) {
//         $start = $event->start->dateTime;
//         if (empty($start)) {
//             $start = $event->start->date;
//         }
//         printf("%s (%s)\n", $event->getSummary(), $start);
//     }
// }

        //  $client = new Google_Client();
        // $authUrl = $client->createAuthUrl();
        //return redirect($authUrl);

 // return response()->json([
 //            "success" => true,
 //            "data" => $getSchedule
 //        ], 201);

        //echo "ok";
        
        //  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        //     $this->client->setAccessToken($_SESSION['access_token']);
        //     $service = new Google_Service_Calendar($this->client);

        //     $calendarId = 'primary';

        //     $results = $service->events->listEvents($calendarId);
        //     return $results->getItems();


        //     //echo "ok2";

        // } else {
        //     //echo "ok1";
        //     return redirect()->route('oauthCallback');
        // }

        return response()->json([
            "success" => true,
            "data" => $getSchedule
        ], 201);
       





    }

    public function getEventDetails(Request $request){

        $username=$request->userid;

        if($username){

            $user = User::where('username',$username)->first();

            $getSchedule =Event::where('link',$request->eventname)->where('user_id',$user->id)->with(['eventschedule'])->first();
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

            $schedule->name = 'Default hours';
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
