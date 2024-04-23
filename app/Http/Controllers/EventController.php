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
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'startDate' => Carbon::parse($event->date)->format('j M'),
                'endDate' => Carbon::parse($event->endDate)->format('j M'),
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
        activity('create event')
            ->performedOn($event)
            ->causedBy($user)
            ->log('Event created');
        return response()->json(['message' => 'Event created', 'event' => $event], 201);
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
        activity('update event')
            ->performedOn($event)
            ->causedBy($user)
            ->log('Event updated');
        return response()->json(['message' => 'Event updated', 'event' => $event]);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        activity()
            ->performedOn($event)
            ->causedBy(auth()->user())
            ->log('Event deleted');
        return response()->json(['message' => 'Event deleted']);
    }
}
