<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AmadeusService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct()
    {
        $this->baseUrl   = rtrim(config('services.amadeus.url'), '/');
        $this->apiKey    = config('services.amadeus.key');
        $this->apiSecret = config('services.amadeus.secret');

        if (!$this->baseUrl || !$this->apiKey || !$this->apiSecret) {
            throw new \RuntimeException('Amadeus API configuration missing.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Get Access Token
    |--------------------------------------------------------------------------
    */

    public function getAccessToken(): string
    {
        return Cache::remember('amadeus_access_token', now()->addMinutes(25), function () {

            try {

                $response = Http::asForm()
                    ->timeout(15)
                    ->retry(2, 300)
                    ->post($this->baseUrl.'/v1/security/oauth2/token', [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->apiKey,
                        'client_secret' => $this->apiSecret
                    ]);

                if (!$response->successful()) {

                    Log::error('Amadeus auth failed', [
                        'response' => $response->body()
                    ]);

                    throw new \Exception('Amadeus authentication failed');
                }

                return $response->json()['access_token'];

            } catch (\Throwable $e) {

                Log::critical('Amadeus token error', [
                    'message' => $e->getMessage()
                ]);

                throw $e;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Popular Destinations
    |--------------------------------------------------------------------------
    */

    public function getPopularDestinations(string $origin = 'NYC'): array
    {
        return Cache::remember("amadeus_popular_{$origin}", now()->addHours(6), function () use ($origin) {

            try {

                $token = $this->getAccessToken();

                $response = Http::withToken($token)
                    ->timeout(20)
                    ->retry(2, 400)
                    ->get($this->baseUrl.'/v1/shopping/flight-destinations', [
                        'origin' => $origin,
                        'maxPrice' => 800
                    ]);

                if (!$response->successful()) {

                    Log::warning('Amadeus destinations failed', [
                        'body' => $response->body()
                    ]);

                    return [];
                }

                $data = $response->json()['data'] ?? [];

                return collect($data)->map(function ($item) {

                    return [
                        'destination' => $item['destination'] ?? null,
                        'price' => [
                            'total' => $item['price']['total'] ?? null,
                            'currency' => $item['price']['currency'] ?? 'USD'
                        ]
                    ];

                })->filter()->values()->toArray();

            } catch (\Throwable $e) {

                Log::error('Destination API exception', [
                    'error' => $e->getMessage()
                ]);

                return [];
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Flight Search
    |--------------------------------------------------------------------------
    */

    public function searchFlights(array $params): array
    {
        try {

            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->timeout(30)
                ->retry(3, 500)
                ->get($this->baseUrl.'/v2/shopping/flight-offers', $params);

            if (!$response->successful()) {

                Log::error('Flight search failed', [
                    'params' => $params,
                    'body' => $response->body()
                ]);

                return [];
            }

            return $response->json()['data'] ?? [];

        } catch (\Throwable $e) {

            Log::error('Flight search exception', [
                'message' => $e->getMessage(),
                'params' => $params
            ]);

            return [];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Normalize Flights (UI Ready)
    |--------------------------------------------------------------------------
    */

    public function normalizeFlights(array $flights): array
    {
        return collect($flights)->map(function ($flight) {

            $segments = $flight['itineraries'][0]['segments'];

            $first = $segments[0];
            $last  = end($segments);

            return [

                'airline' => $first['carrierCode'] ?? null,

                'flight_number' =>
                    ($first['carrierCode'] ?? '').($first['number'] ?? ''),

                'departure_airport' =>
                    $first['departure']['iataCode'] ?? null,

                'arrival_airport' =>
                    $last['arrival']['iataCode'] ?? null,

                'departure_time' =>
                    $first['departure']['at'] ?? null,

                'arrival_time' =>
                    $last['arrival']['at'] ?? null,

                'stops' =>
                    count($segments) - 1,

                'duration' =>
                    $flight['itineraries'][0]['duration'] ?? null,

                'price' =>
                    $flight['price']['grandTotal'] ?? null,

                'currency' =>
                    $flight['price']['currency'] ?? 'USD',

                'booking_class' =>
                    $flight['travelerPricings'][0]['fareOption'] ?? null,

                'seats_remaining' =>
                    $flight['numberOfBookableSeats'] ?? null,

                'raw' => $flight

            ];

        })->values()->toArray();
    }
}