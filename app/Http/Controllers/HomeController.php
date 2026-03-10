<?php

namespace App\Http\Controllers;

use App\Services\AmadeusService;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected AmadeusService $amadeus;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $origin = config('flights.default_origin', 'NYC');

        try {

            $destinations = $this->amadeus->getPopularDestinations($origin);

            // fallback if test API returns empty
            if (empty($destinations)) {
                $destinations = $this->fallbackDestinations();
            }

        } catch (\Throwable $e) {

            Log::error('Homepage destination error', [
                'message' => $e->getMessage()
            ]);

            $destinations = $this->fallbackDestinations();
        }

        return view('pages.home', [
            'destinations' => $destinations,
            'origin' => $origin
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Fallback destinations (for TEST API)
    |--------------------------------------------------------------------------
    */

    private function fallbackDestinations(): array
    {
        return [

            [
                "destination" => "DXB",
                "price" => [
                    "total" => 420,
                    "currency" => "USD"
                ]
            ],

            [
                "destination" => "IST",
                "price" => [
                    "total" => 390,
                    "currency" => "USD"
                ]
            ],

            [
                "destination" => "DOH",
                "price" => [
                    "total" => 450,
                    "currency" => "USD"
                ]
            ],

            [
                "destination" => "CDG",
                "price" => [
                    "total" => 510,
                    "currency" => "USD"
                ]
            ]

        ];
    }
}