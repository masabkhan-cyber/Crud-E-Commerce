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
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .upper-section .website-info {
            font-weight: bold;
            text-decoration: none;
            color: #ffffff;
        }

        .upper-section {
            background-color: #000000;
            padding: 10px 0;
        }

        .upper-section .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .upper-section .website-info {
            font-weight: bold;
        }

        .upper-section .contact-info {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .upper-section .phone-number {
            margin-right: 10px;
            color: #ffffff;
        }

        .upper-section .email {
            color: #ffffff;
        }

        .upper-section .contact-info .icon {
            margin-right: 5px;
            color: #ffffff;
        }

        .lower-section {
            background-color: #ffffff;
            padding: 10px 0;
        }

        .lower-section .container {
            display: flex;
            justify-content: space-between;
        }

        .logo-container img {
            max-width: 150px;
            height: auto;
        }

        .search-form-container {
            margin-left: 20px;
        }

        .search-form-container .search-form {
            display: flex;
            align-items: center;
        }

        .search-form-container .search-form .form-control {
            border-radius: 0;
        }

        .search-form-container .search-form .search-button {
            border-radius: 0;
            margin-left: 10px;
            background-color: transparent;
            border: none;
            color: #000000;
            outline: none;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .search-form-container .search-form .search-button:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="upper-section">
            <div class="container">
                <a href="{{ url('/') }}" class="website-info">{{ config('website-settings.website_name') }}</a>
                <div class="contact-info">
                    <span class="phone-number">
                        <i class="fas fa-phone-alt icon"></i>
                        {{ config('website-settings.phone_number') }}
                    </span>
                    <span class="email">
                        <i class="fas fa-envelope icon"></i>
                        {{ config('website-settings.email') }}
                    </span>
                </div>
            </div>
        </section>
        <section class="lower-section">
            <div class="container">
                    <div class="logo-container">
                        <img src="{{ Storage::url(config('website-settings.logo_path')) }}" alt="Website Logo" class="logo">
                    </div>
                    <div class="search-form-container">
                        <div class="search-form">
                            <form id="searchForm" action="{{ route('products.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control search-input" id="searchInput" name="query" placeholder="Search Your Product">
                                    <button type="submit" class="search-button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </section>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
