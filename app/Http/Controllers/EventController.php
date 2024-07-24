<?php
// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function saveEvent(Request $request)
    {
        $eventName = $request->input('eventName');
        $eventDate = $request->input('eventDate');

        // Validate the inputs
        $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDate' => 'required|date_format:Y-m-d\TH:i:s'
        ]);

        // Save the event to the database
        $event = new Event();
        $event->title = $eventName;
        $event->start_date = $eventDate;
        $event->save();

        return response()->json(['success' => true]);
    }
}
