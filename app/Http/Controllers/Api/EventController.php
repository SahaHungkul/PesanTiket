<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perpage = $request->get('per_page', 5);

            $events = QueryBuilder::for(Event::class)
                ->allowedFilters(['status', 'date'])
                ->allowedSorts(['id', 'name', 'date'])
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('judul', 'like', '%' . $request->search . '%')
                            ->orWhere('description', 'like', '%' . $request->search . '%');
                    });
                })
                ->simplePaginate($perpage);

            return response()->json([
                'message' => 'Events retrieved successfully',
                'data' => EventResource::collection($events),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while retrieving events: ' . $e->getMessage()], 500);
        }
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $event = Event::create($request->validated());
            return response()->json([
                'message' => 'Event created successfully',
                'data' => new EventResource($event),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the event: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        if (! $event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return new EventResource($event);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        try {
            $event = Event::findOrFail($id);

            $event->update($request->validated());
            return response()->json([
                'message' => 'Event updated successfully',
                'data' => new EventResource($event),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}
