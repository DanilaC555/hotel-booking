<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingServices;
use App\Models\Booking;

class BookingController extends Controller
{
    protected BookingServices $service;

    public function __construct(BookingServices $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $bookings = $this->service->index();

        return view('bookings.index', compact('bookings'));

        // return response()->json([
        //     'message' => 'All bookings',
        //     'bookings' => $bookings
        // ], 200);
    }

    public function show(Booking $booking)
    {
        $booking = $this->service->show($booking);

        return view('bookings.show', compact('booking'));
        // return response()->json([
        //     'message' => 'Bookings show',
        //     'booking' => $booking
        // ], 200);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->service->store($request->validated());

        return redirect()->route('bookings.show', $booking);
        // return response()->json([
        //     'message' => 'Bookings create',
        //     'booking' => $booking
        // ], 201);
    }

    public function destroy(Booking $booking)
    {
        $this->service->destroy($booking);

        return redirect()->route('bookings.index')->with('status', 'Бронирование отменено.');
    }
}
