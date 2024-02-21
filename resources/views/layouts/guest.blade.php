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
    <body class="font-sans antialiased min-h-[100vh] min-w-[100%]  grid items-between gap-10 leading-8">
        <!-- Header -->
        <header class="grid items-start">
            @include('layouts.partials.header')
        </header>
        <!-- Page Content -->
        <main class="grid co-ce ">
            <div class="grid it-ce max-w-[80vw] min-w-[300px] mx-5 vsm:mx-auto overflow-scroll my-hide-scrollbar p-10 myShadow rounded-xl ">
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
