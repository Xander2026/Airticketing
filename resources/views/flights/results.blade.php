@extends('layouts.app')

@section('content')

<x-flight-search />

@php
    /*
    |--------------------------------------------------------------------------
    | Detect if a REAL search happened
    |--------------------------------------------------------------------------
    | We require essential fields to be filled before showing results.
    | Prevents results from showing on first page load.
    */

    $searchTriggered =
        request()->filled('origin') &&
        request()->filled('destination') &&
        request()->filled('departure_date');

    $flights = $flights ?? [];
@endphp


@if(!$searchTriggered)

{{-- ========================================
WELCOME / EMPTY STATE
======================================== --}}
<div class="max-w-4xl mx-auto py-24 text-center text-gray-500">

<div class="text-5xl mb-4">✈</div>

<h2 class="text-xl font-semibold mb-2">
Search for flights
</h2>

<p>
Enter your departure, destination and travel date to view available flights.
</p>

</div>


@else

{{-- ========================================
RESULTS LAYOUT
======================================== --}}
<div class="max-w-7xl mx-auto px-4 py-10">

{{-- Search Summary --}}
<div class="bg-white border rounded-xl p-4 mb-8 shadow-sm">

<div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">

<span class="font-semibold text-gray-800">
{{ request('origin') }}
</span>

<span>→</span>

<span class="font-semibold text-gray-800">
{{ request('destination') }}
</span>

<span>|</span>

<span>
{{ request('departure_date') }}
</span>

@if(request('return_date'))
<span> - {{ request('return_date') }}</span>
@endif

</div>

</div>



<div class="grid grid-cols-12 gap-8">


{{-- ========================================
SIDEBAR FILTERS
======================================== --}}
<aside class="col-span-12 md:col-span-3">

<div class="bg-white rounded-xl shadow p-6 space-y-8">


{{-- SORT --}}
<div>

<label class="text-sm font-semibold text-gray-700">
Sort By
</label>

<select class="w-full mt-2 border rounded-lg p-2">
<option value="cheapest">Cheapest</option>
<option value="fastest">Fastest</option>
<option value="best">Best Value</option>
</select>

</div>



{{-- STOPS --}}
<div>

<h3 class="font-semibold text-gray-800 mb-2">
Stops
</h3>

<label class="flex items-center gap-2 text-sm mb-2">
<input type="checkbox"> Nonstop
</label>

<label class="flex items-center gap-2 text-sm mb-2">
<input type="checkbox"> 1 Stop
</label>

<label class="flex items-center gap-2 text-sm">
<input type="checkbox"> 2+ Stops
</label>

</div>



{{-- AIRLINES --}}
<div>

<h3 class="font-semibold text-gray-800 mb-3">
Airlines
</h3>

@php
    $airlines = collect($flights)->pluck('airline')->unique()->filter();
@endphp

@foreach($airlines as $code)

<label class="flex items-center gap-3 mb-2 text-sm">

<input type="checkbox">

<img
src="https://images.kiwi.com/airlines/32/{{$code}}.png"
class="w-5 h-5 object-contain"
onerror="this.src='https://placehold.co/20x20'"
>

<span>
{{ config('airlines.'.$code, $code) }}
</span>

</label>

@endforeach

</div>



{{-- DEPARTURE TIME --}}
<div>

<h3 class="font-semibold text-gray-800 mb-2">
Departure Time
</h3>

<label class="flex items-center gap-2 text-sm mb-2">
<input type="checkbox"> Early Morning (00-06)
</label>

<label class="flex items-center gap-2 text-sm mb-2">
<input type="checkbox"> Morning (06-12)
</label>

<label class="flex items-center gap-2 text-sm mb-2">
<input type="checkbox"> Afternoon (12-18)
</label>

<label class="flex items-center gap-2 text-sm">
<input type="checkbox"> Evening (18-24)
</label>

</div>


</div>

</aside>



{{-- ========================================
FLIGHT RESULTS
======================================== --}}
<main class="col-span-12 md:col-span-9">

<h1 class="text-2xl font-bold mb-6">
Flight Results
</h1>


@if(empty($flights))

<div class="bg-white border rounded-lg p-10 text-center text-gray-500">
No flights found for this route.
</div>

@endif



@foreach($flights as $flight)

@php

$departure = \Carbon\Carbon::parse($flight['departure_time']);
$arrival   = \Carbon\Carbon::parse($flight['arrival_time']);

$duration = str_replace(
['PT','H','M'],
['','h ','m'],
$flight['duration']
);

$airlineCode = $flight['airline'];

@endphp



{{-- ========================================
FLIGHT CARD
======================================== --}}
<div class="bg-white border rounded-xl p-6 mb-6 shadow-sm hover:shadow-md transition">

<div class="flex flex-col md:flex-row items-center justify-between gap-6">



{{-- AIRLINE --}}
<div class="flex items-center gap-4 min-w-[200px]">

<img
src="https://images.kiwi.com/airlines/64/{{$airlineCode}}.png"
class="w-10 h-10 object-contain"
onerror="this.src='https://placehold.co/40x40'"
>

<div>

<div class="font-semibold text-gray-800">
{{ config('airlines.'.$airlineCode, $airlineCode) }}
</div>

<div class="text-sm text-gray-500">
Flight {{$flight['flight_number']}}
</div>

</div>

</div>



{{-- ROUTE --}}
<div class="flex items-center gap-10 text-center">

<div>

<div class="text-xl font-bold">
{{$departure->format('H:i')}}
</div>

<div class="text-sm text-gray-500">
{{$flight['departure_airport']}}
</div>

</div>


<div class="text-gray-400 text-xl">
✈
</div>


<div>

<div class="text-xl font-bold">
{{$arrival->format('H:i')}}
</div>

<div class="text-sm text-gray-500">
{{$flight['arrival_airport']}}
</div>

</div>


<div class="text-sm text-gray-500">

{{$duration}}

@if($flight['stops'] > 0)

<div>{{$flight['stops']}} stop(s)</div>

@else

<div class="text-green-600 font-medium">
Direct
</div>

@endif

</div>

</div>



{{-- PRICE --}}
<div class="text-right min-w-[120px]">

<div class="text-2xl font-bold text-blue-600">
{{$flight['currency']}} {{$flight['price']}}
</div>

<button
class="mt-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
Select
</button>

</div>


</div>

</div>

@endforeach

</main>


</div>
</div>

@endif

@endsection