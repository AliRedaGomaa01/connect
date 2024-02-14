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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{asset('/assets/js/jquery.js')}}"></script>
    </head>
    <body class="font-sans antialiased relative min-h-[100vh]">
        <!-- Header -->

        @include('layouts.partials.header')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        </div>
        <div id='test'class="absolute bottom-0">
            @include('layouts.partials.footer')
        </div>
        @yield('scripts')

    </body>
</html>
