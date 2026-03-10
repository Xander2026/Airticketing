<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmadeusService;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{

    protected $amadeus;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }


    public function search(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date'
        ]);



        /*
        |--------------------------------------------------------------------------
        | Prepare API Parameters
        |--------------------------------------------------------------------------
        */

        $params = [
            'originLocationCode' => strtoupper($validated['origin']),
            'destinationLocationCode' => strtoupper($validated['destination']),
            'departureDate' => $validated['departure_date'],
            'adults' => 1,
            'max' => 20
        ];


        Log::info('Flight search request', [
            'params' => $params
        ]);



        /*
        |--------------------------------------------------------------------------
        | Call Amadeus API
        |--------------------------------------------------------------------------
        */

        try {

            $flights = $this->amadeus->searchFlights($params);

            Log::info('Flight search result', [
                'count' => is_array($flights) ? count($flights) : 0
            ]);

        } catch (\Throwable $e) {

            Log::error('Flight search exception', [
                'message' => $e->getMessage()
            ]);

            $flights = [];
        }



        /*
        |--------------------------------------------------------------------------
        | Optional Debug Mode
        |--------------------------------------------------------------------------
        */

        if ($request->has('debug')) {

            return response()->json([
                'params' => $params,
                'results' => $flights
            ]);

        }



        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('flights.results', [
            'flights' => $flights,
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'departure_date' => $validated['departure_date']
        ]);
    }

}