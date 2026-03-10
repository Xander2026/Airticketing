<!-- ================================
TOP PROMO BAR
================================ -->

<div class="bg-blue-600 text-white text-center text-sm py-2">
    Explore travel deals worldwide. Save up to 30% on flights & hotels
    <a href="#" class="underline font-semibold ml-1 hover:text-gray-200">
        Book Now
    </a>
</div>


<!-- ================================
MAIN NAVBAR
================================ -->

<nav class="bg-white shadow-md sticky top-0 z-50">

<div class="max-w-7xl mx-auto px-6">

<div class="flex items-center justify-between h-16 gap-6">


<!-- LOGO + APP NAME -->

<a href="/" class="flex items-center gap-3">

<img 
src="{{ asset('logo.png') }}" 
alt="{{ config('app.name') }}"
class="h-12 w-12 rounded-full object-cover">

<span class="font-bold text-blue-700 text-lg whitespace-nowrap">
{{ config('app.name') }}
</span>

</a>


<!-- ================================
DESKTOP MENU
================================ -->

<div class="hidden md:flex items-center gap-8 text-gray-700 font-medium">

<a href="/" class="hover:text-blue-600 transition">
Flights
</a>

<a href="#" class="hover:text-blue-600 transition">
Hotels
</a>

<a href="#" class="hover:text-blue-600 transition">
Cars
</a>

<a href="#" class="hover:text-blue-600 transition">
Packages
</a>

<a href="#" class="hover:text-blue-600 transition">
Cruises
</a>

<a href="#" class="hover:text-blue-600 transition">
My Trips
</a>

</div>


<!-- ================================
RIGHT ACTION BUTTONS
================================ -->

<div class="hidden md:flex items-center gap-4">


<a href="/login" class="text-gray-600 hover:text-blue-600 text-sm">
Login
</a>


<a href="/register"
class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-50 transition">
Register
</a>


<a href="/flights/search"
class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700 transition">

Reserve Flight

</a>

</div>


<!-- ================================
MOBILE MENU BUTTON
================================ -->

<button id="menuBtn" class="md:hidden text-2xl text-gray-700">
☰
</button>


</div>

</div>


<!-- ================================
MOBILE MENU
================================ -->

<div id="mobileMenu" class="hidden md:hidden bg-white border-t">

<div class="px-6 py-4 space-y-4 text-gray-700">


<a href="/" class="block hover:text-blue-600">
Flights
</a>

<a href="#" class="block hover:text-blue-600">
Hotels
</a>

<a href="#" class="block hover:text-blue-600">
Cars
</a>

<a href="#" class="block hover:text-blue-600">
Packages
</a>

<a href="#" class="block hover:text-blue-600">
Cruises
</a>

<a href="#" class="block hover:text-blue-600">
My Trips
</a>


<hr>


<a href="/login" class="block hover:text-blue-600">
Login
</a>

<a href="/register" class="block hover:text-blue-600">
Register
</a>


<a href="/flights/search"
class="block bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700">

Reserve Flight

</a>


</div>

</div>

</nav>



<!-- ================================
MOBILE MENU SCRIPT
================================ -->

<script>

document.getElementById('menuBtn').addEventListener('click', function () {

document.getElementById('mobileMenu').classList.toggle('hidden');

});

</script>