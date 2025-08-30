<?php

namespace App\Http\Controllers;

use App\Services\HotelServices;
use App\Models\Hotel;

class HotelController extends Controller
{
    protected HotelServices $service;

    public function __construct(HotelServices $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $hotels = $this->service->index();

        return view('hotels.index', compact('hotels'));
        // return response()->json([
        //     'message' => 'All hotels',
        //     'hotels' => $hotels
        // ], 200);
    }

    public function show(Hotel $hotel)
    {
        $data = $this->service->show($hotel);

        $hotel  = $data['hotel'];
        $rooms  = $data['rooms'];

        return view('hotels.show', compact('hotel', 'rooms'));
        // return response()->json([
        //     'message' => 'Hotel show',
        //     'hotel'   => $data['hotel'],
        //     'rooms'   => $data['rooms'],
        // ]);
    }
}
