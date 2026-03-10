<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AirBooking</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50">

@include('partials.navbar')

<main>
@yield('content')
</main>

@include('partials.footer')

</body>

</html>