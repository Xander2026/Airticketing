<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AirportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

Route::get('/airports', [AirportController::class, 'search']);

/*
| Authenticated User Route
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});