<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventBookingSchedule;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string',
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$event) {
            $event = new Event;
        }

        $event->user_id = $request->user()->id;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->link = $request->link;
        $event->color = $request->color;

        $event->save();

        return response()->json([
            'success' => true,
            'data' => $event
        ], 201);
    }

    public function show(Request $request, Event $event)
    {

        $event = Event::with('eventschedule')->where('events.id',$event->id)->first();
        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    public function index()
    {
        $events = Event::all();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }


    public function destroy(Event $event)
    {
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        } else {
            $event->delete();
            return response()->json([
                'success' => true,
            ], 204);
        }
    }


    public function storeEeventSchedule(Request $request){



         $validator = Validator::make($request->all(), [
            'step2.checkboxval' => 'required',
            'step2.duration' => 'required',
            'availabledates' => 'required|array',
            // 'description' => 'required|string',
            // 'link' => 'required|string',
            // 'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'data'  =>$request->all()
            ], 422);
        }

        if($request->step2['checkboxval']=='daterange'){

            $daterange = $request->dateRange;
        }else{

            $daterange = $request->step2['noofdays'];
        }

        if($request->step2['id']==null){

             $event = EventBookingSchedule::insertGetId([

                    'user_id'=>$request->step2['user_id'],
                    'event_id'=>$request->step2['event_id'],
                    'checked_type'=>$request->step2['checkboxval'],
                    'date_range'=>json_encode($daterange),
                    'availabledates'=>json_encode($request->availabledates),
                    'duration'=>$request->step2['duration'],
                    'before_event'=>$request->step2['beforeevent'],

             ]);

             $insid = $event;

        }else{

                 $event = EventBookingSchedule::where('id',$request->step2['id'])->update([

                    'checked_type'=>$request->step2['checkboxval'],
                    'date_range'=>json_encode($daterange),
                    'availabledates'=>json_encode($request->availabledates),
                    'duration'=>$request->step2['duration'],
                    'before_event'=>$request->step2['beforeevent'],

             ]);

                 $insid = $request->step2['id'];

        }

        $event = EventBookingSchedule::where('id',$insid)->first();



             return response()->json([
            'success' => true,
            'data' => $event
        ], 200);
    }
}
