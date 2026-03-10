<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmadeusService;

class FlightController extends Controller
{

    protected $amadeus;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    public function search(Request $request)
    {

        $request->validate([
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date'
        ]);

        $params = [
            'originLocationCode' => $request->origin,
            'destinationLocationCode' => $request->destination,
            'departureDate' => $request->departure_date,
            'adults' => 1,
            'max' => 20
        ];

        $results = $this->amadeus->searchFlights($params);

        $flights = $results ?? [];

        return view('flights.results', compact('flights'));

    }

}