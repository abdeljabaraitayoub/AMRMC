<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve events with associated user data
        $events = Event::join('users', 'users.id', '=', 'events.User_id')
            ->get(['events.*']);

        $formattedEvents = [];
        foreach ($events as $event) {
            $dateKey = Carbon::parse($event->date)->format('Y-m-d');
            $formattedEvents[$dateKey] = [
                'name' => $event->title,
                'startDate' => Carbon::parse($event->date)->format('j M'),
                'endDate' => Carbon::parse($event->endDate)->format('j M')
            ];
        }

        return $formattedEvents;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $user = auth()->user();
        $request->merge(['User_id' => $user->id]);
        $event = Event::create($request->all());
        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $event;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $user = auth()->user();
        $request->merge(['User_id' => $user->id]);
        $event->update($request->all());
        return $event;

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
