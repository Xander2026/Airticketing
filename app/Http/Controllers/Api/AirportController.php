<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AirportController extends Controller
{

    public function search(Request $request)
    {

        $request->validate([
            'q' => 'required|string|min:2|max:50'
        ]);

        $query = strtoupper(trim($request->get('q')));

        /*
        |--------------------------------------------------------------------------
        | Cache Results
        |--------------------------------------------------------------------------
        | Airport search rarely changes so caching improves performance.
        */

        $cacheKey = "airport_search_" . md5($query);

        $airports = Cache::remember($cacheKey, 300, function () use ($query) {

            return DB::select("
                SELECT 
                    city,
                    airport_name,
                    iata_code,
                    display_name
                FROM airports
                WHERE is_active = 1
                AND (
                    city LIKE ?
                    OR airport_name LIKE ?
                    OR iata_code LIKE ?
                )
                ORDER BY 
                    CASE 
                        WHEN iata_code LIKE ? THEN 1
                        WHEN city LIKE ? THEN 2
                        ELSE 3
                    END,
                    city ASC
                LIMIT 10
            ",[
                "%$query%",
                "%$query%",
                "%$query%",
                "$query%",
                "$query%"
            ]);

        });

        return response()->json($airports);

    }

}