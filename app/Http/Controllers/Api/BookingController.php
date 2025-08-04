<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
            $booking = $this->bookingService->store(
                $request->validated(),
                $user = Auth::user()

            );

            return response()->json([
                'message' => 'Booking successfully.',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Booking failed.',
                'error' => $e->getMessage()
            ], $e->getMessage() === 'Kuota tidak mencukupi.' ? 422 : 500);
        }
    }
}
