<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-6">

<form method="GET" action="/flights/search" id="flightSearchForm">

<!-- SEARCH TABS -->

<div class="flex gap-3 mb-6">

<button type="button"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white font-medium">

✈ Flights

</button>

<button type="button"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-gray-600">

🏨 Hotels

</button>

<button type="button"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-gray-600">

📦 Packages

</button>

<button type="button"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-gray-100 text-gray-600">

🚗 Cars

</button>

</div>


<!-- TRIP TYPE -->

<div class="flex gap-6 text-sm mb-6">

<label class="flex items-center gap-2">
<input type="radio" name="trip_type" value="roundtrip" checked>
Round Trip
</label>

<label class="flex items-center gap-2">
<input type="radio" name="trip_type" value="oneway">
One Way
</label>

<label class="flex items-center gap-2">
<input type="radio" name="trip_type" value="multicity">
Multi City
</label>

</div>


<!-- SEARCH GRID -->

<div class="grid md:grid-cols-6 gap-4 items-end">


<!-- FROM -->

<div class="md:col-span-2 relative">

<label class="text-sm text-gray-600">From</label>

<input
type="text"
name="origin_display"
placeholder="City or airport"
class="w-full border rounded-lg p-3 airport-input"
autocomplete="off">

<input type="hidden" name="origin">

<div class="autocomplete-results absolute bg-white shadow rounded w-full mt-1 z-50"></div>

</div>


<!-- SWAP -->

<div class="flex justify-center">

<button
type="button"
id="swapAirports"
class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full">

⇄

</button>

</div>


<!-- TO -->

<div class="md:col-span-2 relative">

<label class="text-sm text-gray-600">To</label>

<input
type="text"
name="destination_display"
placeholder="City or airport"
class="w-full border rounded-lg p-3 airport-input"
autocomplete="off">

<input type="hidden" name="destination">

<div class="autocomplete-results absolute bg-white shadow rounded w-full mt-1 z-50"></div>

</div>


<!-- DEPART -->

<div>

<label class="text-sm text-gray-600">Depart</label>

<input
type="date"
name="departure_date"
id="departure_date"
class="w-full border rounded-lg p-3">

</div>


<!-- RETURN -->

<div id="returnDateField">

<label class="text-sm text-gray-600">Return</label>

<input
type="date"
name="return_date"
class="w-full border rounded-lg p-3">

</div>

</div>


<!-- PASSENGERS + CABIN -->

<div class="grid md:grid-cols-6 gap-4 mt-4">


<!-- PASSENGERS -->

<div class="md:col-span-2 relative">

<label class="text-sm text-gray-600">Travelers</label>

<button
type="button"
id="passengerToggle"
class="w-full border rounded-lg p-3 text-left">

<span id="passengerSummary">1 Adult</span>

</button>


<!-- PASSENGER POPUP -->

<div id="passengerPopup"
class="absolute bg-white shadow-lg rounded-lg p-4 mt-2 w-64 hidden z-50">

<!-- ADULT -->

<div class="flex justify-between items-center mb-3">

<span>Adults</span>

<div class="flex items-center gap-2">

<button type="button" data-type="adult" class="minus">−</button>

<span id="adultCount">1</span>

<button type="button" data-type="adult" class="plus">+</button>

</div>

</div>


<!-- CHILD -->

<div class="flex justify-between items-center mb-3">

<span>Children</span>

<div class="flex items-center gap-2">

<button type="button" data-type="child" class="minus">−</button>

<span id="childCount">0</span>

<button type="button" data-type="child" class="plus">+</button>

</div>

</div>


<!-- INFANT -->

<div class="flex justify-between items-center">

<span>Infants</span>

<div class="flex items-center gap-2">

<button type="button" data-type="infant" class="minus">−</button>

<span id="infantCount">0</span>

<button type="button" data-type="infant" class="plus">+</button>

</div>

</div>

</div>

</div>


<!-- CABIN -->

<div class="md:col-span-2">

<label class="text-sm text-gray-600">Cabin</label>

<select name="cabin"
class="w-full border rounded-lg p-3">

<option value="ECONOMY">Economy</option>
<option value="PREMIUM_ECONOMY">Premium Economy</option>
<option value="BUSINESS">Business</option>
<option value="FIRST">First Class</option>

</select>

</div>


<!-- SEARCH BUTTON -->

<div class="md:col-span-2 flex items-end">

<button
type="submit"
class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold p-3 rounded-lg">

Find Flights

</button>

</div>


</div>

</form>

</div>