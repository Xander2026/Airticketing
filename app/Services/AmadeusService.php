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

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $this->baseUrl   = rtrim(config('services.amadeus.url'), '/');
        $this->apiKey    = config('services.amadeus.key');
        $this->apiSecret = config('services.amadeus.secret');

        if (!$this->baseUrl || !$this->apiKey || !$this->apiSecret) {
            throw new \RuntimeException(
                'Amadeus configuration missing. Check config/services.php'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Get OAuth Token (Cached)
    |--------------------------------------------------------------------------
    */

    public function getAccessToken(): string
    {
        return Cache::remember('amadeus_access_token', now()->addMinutes(25), function () {

            try {

                $response = Http::asForm()
                    ->timeout(15)
                    ->retry(2, 300)
                    ->post($this->baseUrl . '/v1/security/oauth2/token', [
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
    | Flight Search
    |--------------------------------------------------------------------------
    */

    public function searchFlights(array $params): array
    {
        try {

            $token = $this->getAccessToken();

            $query = array_filter([
                'originLocationCode'      => $params['originLocationCode'] ?? null,
                'destinationLocationCode' => $params['destinationLocationCode'] ?? null,
                'departureDate'           => $params['departureDate'] ?? null,
                'returnDate'              => $params['returnDate'] ?? null,
                'adults'                  => $params['adults'] ?? 1,
                'max'                     => $params['max'] ?? 20
            ]);

            $response = Http::withToken($token)
                ->timeout(30)
                ->retry(3, 400)
                ->get($this->baseUrl . '/v2/shopping/flight-offers', $query);

            if (!$response->successful()) {

                Log::error('Flight search failed', [
                    'params' => $query,
                    'body' => $response->body()
                ]);

                return [];
            }

            $data = $response->json()['data'] ?? [];

            if (empty($data)) {
                return [];
            }

            $normalized = $this->normalizeFlights($data);

            return !empty($normalized) ? $normalized : $data;

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
                    ->get($this->baseUrl . '/v1/shopping/flight-destinations', [
                        'origin' => $origin,
                        'maxPrice' => 800
                    ]);

                if (!$response->successful()) {

                    Log::warning('Amadeus destinations failed', [
                        'body' => $response->body()
                    ]);

                    return [];
                }

                return $response->json()['data'] ?? [];

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
    | Normalize Flights (UI Friendly)
    |--------------------------------------------------------------------------
    */

    public function normalizeFlights(array $flights): array
    {
        return collect($flights)->map(function ($flight) {

            $segments = $flight['itineraries'][0]['segments'] ?? [];

            if (empty($segments)) {
                return null;
            }

            $first = $segments[0];
            $last  = end($segments);

            return [
                'airline' => $first['carrierCode'] ?? null,

                'flight_number' =>
                    ($first['carrierCode'] ?? '') .
                    ($first['number'] ?? ''),

                'departure_airport' =>
                    $first['departure']['iataCode'] ?? null,

                'arrival_airport' =>
                    $last['arrival']['iataCode'] ?? null,

                'departure_time' =>
                    $first['departure']['at'] ?? null,

                'arrival_time' =>
                    $last['arrival']['at'] ?? null,

                'stops' =>
                    max(count($segments) - 1, 0),

                'duration' =>
                    $flight['itineraries'][0]['duration'] ?? null,

                'price' =>
                    $flight['price']['grandTotal'] ?? null,

                'currency' =>
                    $flight['price']['currency'] ?? 'USD',

                'seats_remaining' =>
                    $flight['numberOfBookableSeats'] ?? null,

                'raw' => $flight
            ];

        })->filter()->values()->toArray();
    }
}