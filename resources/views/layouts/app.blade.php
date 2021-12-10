<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-yellow-100 min-h-screen">  
            <div class="flex justify-center">
                <a href="{{ route('happypie.main') }}">
                    <x-application-logo />
                </a>
            </div>
            <div class="flex justify-center mb-2">
                <p class="text-4xl font-extrabold font-serif text-center">HappyCake</p>
            </div>
            

            @include('layouts.navigation')
            <!-- Page Content -->
            <div class="p-10 px-10">
            <main id="app">
                {{ $slot }}
            </main>
            </div>
        </div>
    </body>
</html>
