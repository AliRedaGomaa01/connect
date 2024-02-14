<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Routes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $routes = [
        ['route' => route('landing'), 'name' => 'landing' , 'color' => 'bg-black'],
        ['route' => route('routes'), 'name' => 'routes' , 'color' => 'bg-black'],
        ['route' => route('login'), 'name' => 'login' , 'color' => 'bg-blue-600'],
        ['route' => route('register'), 'name' => 'register' , 'color' => 'bg-blue-600'],
        ['route' => route('dashboard'), 'name' => 'dashboard' , 'color' => 'bg-blue-600'],
        ['route' => route('works.index'), 'name' => 'works' , 'color' => 'bg-red-600'],
];
@endphp
<body>
    <div class="w-full p-10 m-10 grid grid-cols-3 it-ce gap-10 ">
            @foreach ($routes as $route)
                <div class=" p-10 m-10"> <a href="{{ $route['route'] }}" class="border-2 {{ $route['color'] }} py-5 px-10 rounded-xl text-white text-2xl">{{ $route['name'] }}</a> </div>
            @endforeach
    </div>
</body>
</html>