<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-8">

<form method="GET" action="/flights/search" id="flightSearchForm">


<!-- SEARCH TABS -->

<div class="flex flex-wrap gap-3 mb-6">

<button type="button"
class="flex items-center gap-2 px-5 py-2 rounded-full bg-blue-600 text-white font-semibold shadow">
✈ Flights
</button>

<button type="button"
class="flex items-center gap-2 px-5 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
🏨 Hotels
</button>

<button type="button"
class="flex items-center gap-2 px-5 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
📦 Packages
</button>

<button type="button"
class="flex items-center gap-2 px-5 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
🚗 Cars
</button>

</div>


<!-- TRIP TYPE -->

<div class="flex items-center gap-6 mb-6 text-sm">

<label class="flex items-center gap-2 cursor-pointer">
<input type="radio" name="trip_type" value="roundtrip" checked class="text-blue-600">
<span class="font-medium text-gray-700">Round Trip</span>
</label>

<label class="flex items-center gap-2 cursor-pointer">
<input type="radio" name="trip_type" value="oneway" class="text-blue-600">
<span class="font-medium text-gray-700">One Way</span>
</label>

<label class="flex items-center gap-2 cursor-pointer">
<input type="radio" name="trip_type" value="multicity" class="text-blue-600">
<span class="font-medium text-gray-700">Multi City</span>
</label>

</div>



<!-- SEARCH ROW -->

<div class="grid md:grid-cols-12 gap-4">


<!-- FROM -->

<div class="md:col-span-3 relative">

<label class="text-sm text-gray-600 mb-1 block">
From
</label>

<input
type="text"
name="origin_display"
placeholder="Departure airport (e.g. Kigali - KGL)"
class="w-full border border-gray-300 rounded-lg p-3 airport-input focus:ring-2 focus:ring-blue-500"
autocomplete="off">

<input type="hidden" name="origin">

<div class="autocomplete-results absolute bg-white shadow rounded w-full mt-1 z-50"></div>

</div>


<!-- SWAP -->

<div class="md:col-span-1 flex items-end justify-center">

<button
type="button"
id="swapAirports"
class="bg-gray-100 hover:bg-gray-200 w-10 h-10 flex items-center justify-center rounded-full">
⇄
</button>

</div>


<!-- TO -->

<div class="md:col-span-3 relative">

<label class="text-sm text-gray-600 mb-1 block">
To
</label>

<input
type="text"
name="destination_display"
placeholder="Arrival airport (e.g. London - LHR)"
class="w-full border border-gray-300 rounded-lg p-3 airport-input focus:ring-2 focus:ring-blue-500"
autocomplete="off">

<input type="hidden" name="destination">

<div class="autocomplete-results absolute bg-white shadow rounded w-full mt-1 z-50"></div>

</div>


<!-- DEPART -->

<div class="md:col-span-2">

<label class="text-sm text-gray-600 mb-1 block">
Departure
</label>

<input
type="text"
name="departure_date"
id="departure_date"
placeholder="Select departure date"
class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

</div>


<!-- RETURN -->

<div id="returnDateField" class="md:col-span-2">

<label class="text-sm text-gray-600 mb-1 block">
Return
</label>

<input
type="text"
name="return_date"
placeholder="Select return date"
class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

</div>

</div>



<!-- SECOND ROW -->

<div class="grid md:grid-cols-12 gap-4 mt-6">


<!-- TRAVELERS -->

<div class="md:col-span-3 relative">

<label class="text-sm text-gray-600 mb-1 block">
Travelers
</label>

<button
type="button"
id="passengerToggle"
class="w-full border border-gray-300 rounded-lg p-3 text-left bg-white hover:border-blue-500">

<span id="passengerSummary">1 Adult</span>

</button>


<!-- POPUP -->

<div id="passengerPopup"
class="absolute bg-white shadow-xl rounded-xl p-5 mt-2 w-72 hidden z-50 border">


<div class="flex justify-between items-center mb-4">

<div>
<p class="font-medium">Adults</p>
<p class="text-xs text-gray-500">12+</p>
</div>

<div class="flex items-center gap-3">

<button type="button" data-type="adult"
class="minus w-8 h-8 border rounded-full">−</button>

<span id="adultCount">1</span>

<button type="button" data-type="adult"
class="plus w-8 h-8 border rounded-full">+</button>

</div>

</div>


<div class="flex justify-between items-center mb-4">

<div>
<p class="font-medium">Children</p>
<p class="text-xs text-gray-500">2-11</p>
</div>

<div class="flex items-center gap-3">

<button type="button" data-type="child"
class="minus w-8 h-8 border rounded-full">−</button>

<span id="childCount">0</span>

<button type="button" data-type="child"
class="plus w-8 h-8 border rounded-full">+</button>

</div>

</div>


<div class="flex justify-between items-center">

<div>
<p class="font-medium">Infants</p>
<p class="text-xs text-gray-500">Under 2</p>
</div>

<div class="flex items-center gap-3">

<button type="button" data-type="infant"
class="minus w-8 h-8 border rounded-full">−</button>

<span id="infantCount">0</span>

<button type="button" data-type="infant"
class="plus w-8 h-8 border rounded-full">+</button>

</div>

</div>

</div>

</div>



<!-- CABIN -->

<div class="md:col-span-3">

<label class="text-sm text-gray-600 mb-1 block">
Cabin Class
</label>

<select name="cabin"
class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

<option value="ECONOMY">Economy</option>
<option value="PREMIUM_ECONOMY">Premium Economy</option>
<option value="BUSINESS">Business</option>
<option value="FIRST">First Class</option>

</select>

</div>


<!-- SEARCH -->

<div class="md:col-span-3 flex items-end">

<button
type="submit"
class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold p-3 rounded-lg shadow">
Find Flights
</button>

</div>

</div>

</form>

</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

/* -----------------------------
   DATE PICKERS
----------------------------- */

flatpickr("#departure_date",{
    dateFormat:"Y-m-d",
    minDate:"today"
});

flatpickr("input[name='return_date']",{
    dateFormat:"Y-m-d",
    minDate:"today"
});


/* -----------------------------
   TRIP TYPE TOGGLE
----------------------------- */

document.querySelectorAll("input[name='trip_type']").forEach(el => {

    el.addEventListener("change", function(){

        const returnField = document.getElementById("returnDateField");

        if(this.value === "oneway"){
            returnField.style.display = "none";
        }else{
            returnField.style.display = "block";
        }

    });

});


/* -----------------------------
   AIRPORT SWAP
----------------------------- */

document.getElementById("swapAirports").addEventListener("click", function(){

    const from = document.querySelector("input[name='origin_display']");
    const to   = document.querySelector("input[name='destination_display']");

    const temp = from.value;
    from.value = to.value;
    to.value = temp;

});


/* -----------------------------
   PASSENGER POPUP TOGGLE
----------------------------- */

const passengerToggle = document.getElementById("passengerToggle");
const passengerPopup  = document.getElementById("passengerPopup");

passengerToggle.addEventListener("click", function(){
    passengerPopup.classList.toggle("hidden");
});


/* -----------------------------
   PASSENGER COUNTERS
----------------------------- */

let adult  = 1;
let child  = 0;
let infant = 0;

const adultCount  = document.getElementById("adultCount");
const childCount  = document.getElementById("childCount");
const infantCount = document.getElementById("infantCount");

const passengerSummary = document.getElementById("passengerSummary");


function updatePassengerSummary(){

    const parts = [];

    if(adult > 0){
        parts.push(adult + " Adult" + (adult > 1 ? "s" : ""));
    }

    if(child > 0){
        parts.push(child + " Child" + (child > 1 ? "ren" : ""));
    }

    if(infant > 0){
        parts.push(infant + " Infant" + (infant > 1 ? "s" : ""));
    }

    passengerSummary.innerText = parts.join(", ");

}


/* PLUS BUTTONS */

document.querySelectorAll(".plus").forEach(btn => {

    btn.addEventListener("click", function(){

        const type = this.dataset.type;

        if(type === "adult"){
            adult++;
            adultCount.innerText = adult;
        }

        if(type === "child"){
            child++;
            childCount.innerText = child;
        }

        if(type === "infant"){
            infant++;
            infantCount.innerText = infant;
        }

        updatePassengerSummary();

    });

});


/* MINUS BUTTONS */

document.querySelectorAll(".minus").forEach(btn => {

    btn.addEventListener("click", function(){

        const type = this.dataset.type;

        if(type === "adult" && adult > 1){
            adult--;
            adultCount.innerText = adult;
        }

        if(type === "child" && child > 0){
            child--;
            childCount.innerText = child;
        }

        if(type === "infant" && infant > 0){
            infant--;
            infantCount.innerText = infant;
        }

        updatePassengerSummary();

    });

});


/* -----------------------------
   CLOSE POPUP ON OUTSIDE CLICK
----------------------------- */

document.addEventListener("click", function(e){

    if(!passengerPopup.contains(e.target) && !passengerToggle.contains(e.target)){
        passengerPopup.classList.add("hidden");
    }

});


});

</script>