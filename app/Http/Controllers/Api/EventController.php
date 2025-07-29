<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return EventResource::collection(Event::all());
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());
        return new EventResource($event);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        if (! $event){
            return response()->json(['message' => 'Event not found'], 404);
        }

        return new EventResource($event);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        if (! $event){
            return response()->json(['message' => 'Event not found'],404);
        }

        $event->update($request->validated());
        return new EventResource($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if (! $event){
            return response()->json(['message' => 'Event not found'],404);
        }
    }
}
