<?php

namespace App\Services;

class FlightSearchService
{
    protected $amadeus;

    public function __construct(AmadeusService $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    public function search(array $params)
    {
        $results = $this->amadeus->searchFlights($params);

        return $this->formatFlights($results);
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Flight Results
    |--------------------------------------------------------------------------
    */

    protected function formatFlights($flights)
    {
        $data = [];

        foreach ($flights as $flight) {

            $segment = $flight['itineraries'][0]['segments'][0];

            $data[] = [
                'airline' => $segment['carrierCode'],
                'from' => $segment['departure']['iataCode'],
                'to' => $segment['arrival']['iataCode'],
                'departure' => $segment['departure']['at'],
                'arrival' => $segment['arrival']['at'],
                'price' => $flight['price']['grandTotal'],
                'currency' => $flight['price']['currency']
            ];
        }

        return $data;
    }
}