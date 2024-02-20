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
    <body class="font-sans antialiased relative min-h-[100vh] w-[100vw] min-w-[900px] grid items-between gap-10 ">
        <!-- Header -->
        <header class="grid items-start">
            @include('layouts.partials.header')
        </header>
        <!-- Page Content -->
        <main class="grid co-ce mx-auto w-[600px] lg:w-[70vh] myShadow m-5 rounded-xl p-5">
            <div class="w-[500px] lg:w-[60vh] p-5">
                {{ $slot }}
            </div>
        </main>
        <!-- Footer -->
        <footer class="grid items-end">
            <div class="grid it-ce  bg-main px-10 py-5 w-full myTopShadow">
                @include('layouts.partials.footer')
            </div>
        </footer>
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>
