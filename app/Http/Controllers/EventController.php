<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
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
}
