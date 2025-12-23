<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

{{-- <link rel="icon" href="#" sizes="any">
<link rel="icon" href="#" type="image/svg+xml">
<link rel="apple-touch-icon" href="#"> --}}

<link rel="icon" href="{{ asset('favicon-new.png?v=9999') }}" type="image/png">


<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
