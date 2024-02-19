{{-- frontend lang --}}
@php
    $appEn = [
        'dir' => 'ltr' ,
        'lang' => 'en' ,
    ];
    $appAr = [
        'dir' => 'rtl' ,
        'lang' => 'ar' ,
    ];
    $app = app()->isLocale('ar') ?  $appAr : $appEn;
@endphp
<!DOCTYPE html>
<html lang="{{ $app['lang'] }}" dir="{{ $app['dir'] }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="{{asset('/assets/js/jquery.js')}}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased relative min-h-[100vh]">
        <!-- Header -->
        @include('layouts.partials.header')
        <!-- Page Content -->
        <main class="grid it-ce my-[5rem] mx-auto min-h-[60vh] vsm:w-[300px]  sm:w-[500px] md:w-[700px] lg:w-[900px] ">
            <div class="myShadow p-5 rounded-xl w-[80vw] vsm:w-[80%] lg:[50%]">
                {{ $slot }}
            </div>
        </main>
        <!-- Footer -->
        <div class="p-10"></div>
        <div id='test'class="absolute bottom-0 w-[100%] bg-black">
            @include('layouts.partials.footer')
        </div>
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>
