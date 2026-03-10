@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="bg-primary text-white py-24">
<div class="max-w-7xl mx-auto text-center px-6">

<h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
Find Flights. <span class="text-accent">Save More.</span>
</h1>

<p class="text-lg md:text-xl opacity-90 mb-10">
Compare hundreds of airlines and book the best flight deals worldwide.
</p>

<x-flight-search />

</div>
</section>


<!-- POPULAR DESTINATIONS -->
<section class="py-20 bg-gray-50">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-3xl md:text-4xl font-bold text-center mb-14">
Popular Destinations
</h2>

@if(!empty($destinations))

<div class="grid md:grid-cols-4 gap-8">

@foreach($destinations as $destination)

@php
$code = strtoupper($destination['destination']);
$image = destinationImage($code);
$price = $destination['price']['total'] ?? '--';

/* DEBUG */
$debugImage = $image ?? 'NULL';
@endphp

<!-- DEBUG COMMENT -->
<!-- Destination: {{ $code }} | Image: {{ $debugImage }} -->

<div class="bg-white rounded-xl shadow hover:shadow-2xl transition overflow-hidden group">

<div class="relative">

<img
src="{{ $image }}"
alt="{{ $code }}"
loading="lazy"
class="w-full h-48 object-cover group-hover:scale-105 transition duration-500"
onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80';"
>

<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

<div class="absolute bottom-4 left-4 text-white font-bold text-lg">
{{ $code }}
</div>

{{-- DEBUG BADGE --}}
@if(config('app.debug'))
<div class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded">
{{ $code }}
</div>
@endif

</div>

<div class="p-4">

<p class="text-gray-500 text-sm">
Flights from
</p>

<p class="text-accent text-xl font-bold">
${{ $price }}
</p>

</div>

</div>

@endforeach

</div>

@else

<div class="text-center text-gray-500">
Destinations will appear here once flight data is available.
</div>

@endif

</div>

</section>



<!-- FLIGHT DEALS -->
<section class="py-20">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-3xl md:text-4xl font-bold text-center mb-14">
Today's Flight Deals
</h2>

<div class="grid md:grid-cols-3 gap-10">

@foreach(array_slice($destinations,0,3) as $deal)

@php
$code = strtoupper($deal['destination']);
$image = destinationImage($code);
$price = $deal['price']['total'] ?? '--';
@endphp

<div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

<img
src="{{ $image }}"
alt="{{ $code }}"
loading="lazy"
class="w-full h-40 object-cover"
onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80';"
>

<div class="p-6">

<h3 class="font-bold text-lg mb-1">
Kigali → {{ $code }}
</h3>

<p class="text-gray-500 text-sm mb-4">
Best airline deals available
</p>

<p class="text-accent text-2xl font-bold">
${{ $price }}
</p>

<a
href="/flights/search?origin=KGL&destination={{ $code }}"
class="inline-block mt-5 bg-primary text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">

View Deal

</a>

</div>

</div>

@endforeach

</div>

</div>

</section>



<!-- WHY BOOK WITH US -->
<section class="bg-gray-100 py-24">

<div class="max-w-7xl mx-auto px-6 text-center">

<h2 class="text-3xl md:text-4xl font-bold mb-16">
Why Book With Us
</h2>

<div class="grid md:grid-cols-3 gap-12">

<div>
<div class="text-accent text-5xl mb-4">✈</div>
<h3 class="font-bold text-lg mb-2">Best Price Guarantee</h3>
<p class="text-gray-500">
We compare hundreds of airlines to find the cheapest flights.
</p>
</div>

<div>
<div class="text-accent text-5xl mb-4">⚡</div>
<h3 class="font-bold text-lg mb-2">Instant Booking</h3>
<p class="text-gray-500">
Book flights instantly with fast and secure checkout.
</p>
</div>

<div>
<div class="text-accent text-5xl mb-4">🛡</div>
<h3 class="font-bold text-lg mb-2">Secure Platform</h3>
<p class="text-gray-500">
Your payments and personal data are fully protected.
</p>
</div>

</div>

</div>

</section>



<!-- AIRLINE PARTNERS -->
<section class="py-20">

<div class="max-w-7xl mx-auto text-center px-6">

<h2 class="text-3xl md:text-4xl font-bold mb-14">
Airline Partners
</h2>

<div class="flex justify-center flex-wrap gap-12 opacity-80">

<img src="https://images.kiwi.com/airlines/64/EK.png" class="h-10">
<img src="https://images.kiwi.com/airlines/64/QR.png" class="h-10">
<img src="https://images.kiwi.com/airlines/64/TK.png" class="h-10">
<img src="https://images.kiwi.com/airlines/64/KQ.png" class="h-10">
<img src="https://images.kiwi.com/airlines/64/BA.png" class="h-10">
<img src="https://images.kiwi.com/airlines/64/LH.png" class="h-10">

</div>

</div>

</section>

@endsection