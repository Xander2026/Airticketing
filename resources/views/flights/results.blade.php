@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-10">

<h1 class="text-2xl font-bold mb-8">Flight Results</h1>

@foreach($flights as $flight)

@php

$segment = $flight['itineraries'][0]['segments'][0];

$departure = \Carbon\Carbon::parse($segment['departure']['at']);
$arrival = \Carbon\Carbon::parse($segment['arrival']['at']);

$price = $flight['price']['grandTotal'];

$airlineCode = $segment['carrierCode'];

$airlineName = config('airlines.'.$airlineCode) ?? $airlineCode;

$duration = $flight['itineraries'][0]['duration'];

@endphp


<div class="bg-white rounded-xl border p-6 mb-5 shadow-sm hover:shadow-md transition">

<div class="flex items-center justify-between">

<div class="flex items-center gap-6">

<img
src="https://images.kiwi.com/airlines/64/{{$airlineCode}}.png"
class="w-10 h-10"
>

<div class="text-sm text-gray-600">

<div class="font-semibold text-gray-800">
{{$airlineName}}
</div>

<div>
{{$airlineCode}}
</div>

</div>

</div>



<div class="flex items-center gap-12">

<div class="text-center">

<div class="text-xl font-bold">
{{$departure->format('H:i')}}
</div>

<div class="text-sm text-gray-500">
{{$segment['departure']['iataCode']}}
</div>

</div>


<div class="text-gray-400 text-xl">
✈
</div>


<div class="text-center">

<div class="text-xl font-bold">
{{$arrival->format('H:i')}}
</div>

<div class="text-sm text-gray-500">
{{$segment['arrival']['iataCode']}}
</div>

</div>


<div class="text-sm text-gray-500">

{{$duration}}

</div>

</div>



<div class="text-right">

<div class="text-2xl font-bold text-blue-600">
${{$price}}
</div>

<button class="mt-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
Select
</button>

</div>


</div>

</div>

@endforeach

</div>

@endsection