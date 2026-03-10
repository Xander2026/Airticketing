@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

<h1 class="text-2xl font-bold mb-8">
Flight Results
</h1>


{{-- No flights --}}
@if(empty($flights))

<div class="bg-white rounded-lg border p-6 text-center text-gray-500">
No flights found for this route.
</div>

@endif



@foreach($flights as $flight)

@php

$departure = \Carbon\Carbon::parse($flight['departure_time']);
$arrival = \Carbon\Carbon::parse($flight['arrival_time']);

$airline = $flight['airline'];
$price = $flight['price'];
$currency = $flight['currency'];
$duration = str_replace(['PT','H','M'],['','h ','m'],$flight['duration']);

@endphp


<div class="bg-white border rounded-xl p-6 mb-5 shadow-sm hover:shadow-md transition">

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">


{{-- Airline --}}
<div class="flex items-center gap-4">

<img
src="https://images.kiwi.com/airlines/64/{{$airline}}.png"
class="w-10 h-10 object-contain"
onerror="this.src='https://placehold.co/40x40'"
>

<div class="text-sm">

<div class="font-semibold text-gray-800">
{{$airline}}
</div>

<div class="text-gray-500">
Flight {{$flight['flight_number']}}
</div>

</div>

</div>



{{-- Route --}}
<div class="flex items-center gap-8 text-center">

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

<div>Direct</div>

@endif

</div>

</div>



{{-- Price --}}
<div class="text-right">

<div class="text-2xl font-bold text-blue-600">

{{$currency}} {{$price}}

</div>

<button
class="mt-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">

Select

</button>

</div>


</div>

</div>

@endforeach


</div>

@endsection