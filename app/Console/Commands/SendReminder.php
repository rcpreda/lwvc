<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;
use App\Models\User;
use App\Models\Event;
use App\Models\Slotbooking;
use Date;
use DateTime;
use DateTimeZone;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder about meetings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         //Log::info("Cron is working fine!");
         $getDetails = Slotbooking::with(['user','event'])->where('slotbookings.calendar_type','=','application_calendar')->get();
        foreach($getDetails as $key=>$details)
        {

            $getallreminder = json_decode($details->reminder_before);
            $getAllremindernotify = json_decode($details->reminder_notify_by);

            $getslot = explode('-',$details->slot)[0];
            $getdate = $details->confirmdate;

            $newdate = $getdate.' '.$getslot;
            $newdate_format = new DateTime($newdate);

            $d1 = strtotime($newdate_format->format('Y-m-d H:i:s'));

            $date = new DateTime("now", new DateTimeZone($details->timezone) );
            $d2 = strtotime($date->format('Y-m-d H:i:s'));
              $intervalinSec = abs($d1-$d2);
              $totalMinutesDiff = $intervalinSec/60;
              $totalHoursDiff   = $intervalinSec/60/60;
              $totalDaysDiff    = $intervalinSec/60/60/24;
              $mailmsg = "";
            foreach ($getallreminder as $key => $value) 
            {

                $getreminder = explode(' ',$value);

                if($getreminder[1]=='minutes'){



                    if($totalMinutesDiff >(int)$getreminder[0]-1 && $totalMinutesDiff <(int)$getreminder[0]+1){

                    $datetoday = new DateTime("now", new DateTimeZone($details->timezone) );
                    $today = $datetoday->format('Y-m-d h:m a');

                        $mailmsg ="send mail before minutes at".$today;


                        if(in_array('email',$getAllremindernotify)){
                            $sendemail = $details->email;
                            $details= [
                            'name' => $details->name,   
                            'email' => $details->email,   
                            'eventname' => $details->event->name,   
                            'description' => $details->event->description,   
                            'slot' => $details->slot,
                            'timezone' => $details->timezone,
                            'datetime' => $details->confirmdate,  
                            'reminder'=>$getreminder[0].'minutes before'
                            ];

                            \Mail::to($sendemail)->send(new \App\Mail\SendReminderMail($details));

                        }

                         if(in_array('sms',$getAllremindernotify)){
                            

                        }



                       

                        // if(in_array()){

                        // }

                    }




                }
                if($getreminder[1]=='hour'){

                    $gethoursInminutes = (int)$getreminder[0]*60;

                         if($totalMinutesDiff >$gethoursInminutes-1 && $totalMinutesDiff<$gethoursInminutes+1){

                    $datetoday = new DateTime("now", new DateTimeZone($details->timezone) );
                    $today = $datetoday->format('Y-m-d h:m a');

                        $mailmsg = "send mail before 1 hour at".$today;

                         if(in_array('email',$getAllremindernotify)){
                            $sendemail = $details->email;
                            $details= [
                            'name' => $details->name,   
                            'email' => $details->email,   
                            'eventname' => $details->event->name, 
                            'description' => $details->event->description,   
                            'slot' => $details->slot,
                             'timezone' => $details->timezone,
                            'datetime' => $details->confirmdate,  
                            'reminder'=>$getreminder[0].'hour before'
                            ];

                            \Mail::to($sendemail)->send(new \App\Mail\SendReminderMail($details));

                        }

                         if(in_array('sms',$getAllremindernotify)){
                            

                        }






                    }


                }

                if($getreminder[1]=='day'){

                    $getdaysInminutes = (int)$getreminder[0] * 1440;

                     if($totalMinutesDiff > $getdaysInminutes-1 && $totalMinutesDiff <$getdaysInminutes+1){

                    $datetoday = new DateTime("now", new DateTimeZone($details->timezone) );
                    $today = $datetoday->format('Y-m-d h:m a');

                        $mailmsg = "send mail before 1 day at".$today;

                         if(in_array('email',$getAllremindernotify)){
                            $sendemail = $details->email;
                            $details= [

                            'name' => $details->name,   
                            'email' => $details->email,   
                            'eventname' => $details->event->name, 
                            'description' => $details->event->description,   
                            'slot' => $details->slot, 
                             'timezone' => $details->timezone,
                            'datetime' => $details->confirmdate, 
                            'reminder'=>$getreminder[0].'day before'
                            ];

                            \Mail::to($sendemail)->send(new \App\Mail\SendReminderMail($details));

                        }

                         if(in_array('sms',$getAllremindernotify)){
                            

                        }


                    }

                    
                }

            }
            


        }

    }
}
