<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('website-settings.website_name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome 5 CDN -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" />

    <!-- Vite CSS and JS -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        #searchInput {
            border-radius: 0;
        }
    </style>
</head>

<body>
    <div id="app">

    <!-- Include the header (navigation) section -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ Storage::url(config('website-settings.logo_path')) }}" alt="..." height="36">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/') }}">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">About Us</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Categories</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Category1</a></li>
            <li><a class="dropdown-item" href="#">Category2</a></li>
            <li><a class="dropdown-item" href="#">Category3</a></li>
        </ul>
        </li>
        </ul>
        <form class="d-flex" action="{{ route('products.search') }}" method="GET">
        <input class="form-control me-2" type="text" name="query" placeholder="Search Your Product" id="searchInput">
        <button class="btn btn-primary" type="submit">
        <i class="fas fa-search text-white"></i>
        </button>
        </form>
    </div>
    </div>
    </nav>

        <main class="py-4">
            @yield('content')
        </main>

         <!-- Include the footer section -->
        <footer class="bg-dark text-white text-center py-3">
        @yield('footer')
        <p>{{ config('website-settings.phone_number') }}.</p>
        <p>{{ config('website-settings.email') }}.</p>
        <p>&copy; {{ date('Y') }} {{ config('website-settings.website_name') }}. All rights reserved.</p>
        </footer>
        </div>

</body>
</html>
