<div class="flight-search-wrapper">

<form method="GET" action="/flights/search" id="flightSearchForm">

<!-- Tabs -->

<div class="search-tabs">

<button type="button" class="tab active">
<span class="icon">✈</span> Flights
</button>

<button type="button" class="tab">
<span class="icon">🏨</span> Hotels
</button>

<button type="button" class="tab">
<span class="icon">📦</span> Packages
</button>

<button type="button" class="tab">
<span class="icon">🚗</span> Cars
</button>

</div>


<!-- Trip type -->

<div class="trip-types">

<label>
<input type="radio" name="trip_type" value="roundtrip" checked>
Round Trip
</label>

<label>
<input type="radio" name="trip_type" value="oneway">
One Way
</label>

<label>
<input type="radio" name="trip_type" value="multicity">
Multi City
</label>

</div>


<!-- Search fields -->

<div class="search-grid">

<!-- FROM -->

<div class="search-field relative">

<label>From</label>

<input
type="text"
name="origin_display"
placeholder="City or airport"
class="airport-input"
autocomplete="off"
/>

<input type="hidden" name="origin">

<div class="autocomplete-results"></div>

</div>


<!-- Swap -->

<div class="swap-wrapper">

<button
type="button"
id="swapAirports"
class="swap-airports">

⇄

</button>

</div>


<!-- TO -->

<div class="search-field relative">

<label>To</label>

<input
type="text"
name="destination_display"
placeholder="City or airport"
class="airport-input"
autocomplete="off"
/>

<input type="hidden" name="destination">

<div class="autocomplete-results"></div>

</div>


<!-- DEPART -->

<div class="search-field">

<label>Depart</label>

<input
type="date"
name="departure_date"
id="departure_date"
/>

</div>


<!-- RETURN -->

<div class="search-field" id="returnDateField">

<label>Return</label>

<input
type="date"
name="return_date"
/>

</div>


<!-- PASSENGERS -->

<div class="search-field">

<label>Travelers</label>

<button type="button" id="passengerToggle" class="passenger-display">

<span id="passengerSummary">1 Adult</span>

</button>

<div id="passengerPopup" class="passenger-popup hidden">

<div class="passenger-row">
Adults
<div class="counter">
<button type="button" data-type="adult" class="minus">−</button>
<span id="adultCount">1</span>
<button type="button" data-type="adult" class="plus">+</button>
</div>
</div>

<div class="passenger-row">
Children
<div class="counter">
<button type="button" data-type="child" class="minus">−</button>
<span id="childCount">0</span>
<button type="button" data-type="child" class="plus">+</button>
</div>
</div>

<div class="passenger-row">
Infants
<div class="counter">
<button type="button" data-type="infant" class="minus">−</button>
<span id="infantCount">0</span>
<button type="button" data-type="infant" class="plus">+</button>
</div>
</div>

</div>

</div>


<!-- CABIN -->

<div class="search-field">

<label>Cabin</label>

<select name="cabin">

<option value="ECONOMY">Economy</option>
<option value="PREMIUM_ECONOMY">Premium Economy</option>
<option value="BUSINESS">Business</option>
<option value="FIRST">First Class</option>

</select>

</div>


<!-- SEARCH -->

<div class="search-submit">

<button type="submit" class="search-button">

Find Flights

</button>

</div>


</div>

</form>

</div>