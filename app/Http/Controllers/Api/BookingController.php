<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(BookingRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $booking = $this->bookingService->store(
                $request->validated(),
                $user = Auth::user()
            );

            DB::commit();
            return response()->json([
                'message' => 'Booking successfully.',
                'data' => new BookingResource($booking)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Booking failed.',
                'error' => $e->getMessage()
            ], $e->getMessage() === 'Kuota tidak mencukupi.' ? 422 : 500);
        }
    }

    public function index()
    {
        $userId = Auth::id();
        Log::info("Authenticated user ID: $userId");

        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        Log::info('Bookings found: ' . $bookings->count());

        return response()->json([
            'message' => 'Bookings retrieved successfully.',
            'data' => BookingResource::collection($bookings)
        ]);
    }

    public function show($id): BookingResource
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return new BookingResource($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        DB::transaction(function () use ($booking) {
            // Kembalikan kuota event
            $event = $booking->event;
            $event->kuota += $booking->jumlah;
            $event->save();

            $booking->delete();
        });

        return response()->json(['message' => 'Booking dibatalkan']);
    }
}
