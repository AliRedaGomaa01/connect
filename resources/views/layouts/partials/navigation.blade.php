{{-- frontend lang --}}
@php
    # lang
    $navEn =  [
        'dashboard' => 'Dashboard' ,
        'profile' => 'Profile' ,
        'logout' => 'Logout' ,
        'lang' => 'العربية' ,
    ];
    $navAr = [
        'dashboard' => 'لوحة التحكم' ,
        'profile' => 'الملف الشخصي' ,
        'logout' => 'تسجيل الخروج' ,
        'lang' => 'English' ,
    ];
    $nav = app()->isLocale('ar') ?  $navAr : $navEn;
    # others 
    $url = request()->url();
    $hasQuery = count(explode('?', $url)) > 1;
    $routes = [
        'dashboard' => route('dashboard') ,
        'profile' => route('profile.edit') ,
        'logout' => route('logout') ,
        'lang' => app()->isLocale('ar') ? ( $hasQuery ? $url.'&locale=en' : $url.'?locale=en') : ( $hasQuery ? $url.'&locale=ar' : $url.'?locale=ar' ),
    ] ;
@endphp
<nav>
    {{-- Permanent Nav --}}
    <div class="bg-white items-center p-10   myBottomShadow relative z-10">
        <ul class="grid grid-cols-1 vsm:grid-cols-4 gap-5 it-ce text-main">
            @foreach ($nav as $key => $value)
                @if ($key == 'logout')
                    <form action="{{$routes[$key]}}" method="post" >
                        @csrf
                        <li >
                            <button type="submit"  class="{{ $routes[$key] === url()->current() ? 'active' : '' }} ">
                                <a class="hover:active "> {{$value}} </a>
                            </button>
                        </li>
                    </form>
                @else 
                    <li>
                        <a href="{{$routes[$key]}}" class="{{ $routes[$key] === url()->current() ? 'active' : '' }} hover:active">{{$value}}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="bg-white items-center p-10   myBottomShadow relative z-10">
        <ul class="grid grid-cols-1 vsm:grid-cols-3 gap-5 it-ce text-main">
                    <li>
                        <a href="{{route('users.index')}}" class="{{ route('users.index') === url()->current() ? 'active' : '' }} hover:active">{{__("Users")}}</a>
                    </li>
                    <li>
                        <a href="{{route('works.index')}}" class="{{ route('works.index') === url()->current() ? 'active' : '' }} hover:active">{{__("Followed Works")}}</a>
                    </li>
                    <li>
                        <a href="{{route('images.index')}}" class="{{ route('images.index') === url()->current() ? 'active' : '' }} hover:active">{{__("Followed Images")}}</a>
                    </li>
        </ul>
    </div>
    {{-- Navs for specific pages --}}

    {{ $nav2 ?? '' }}
    {{ $nav3 ?? '' }}
    {{ $nav4 ?? '' }}
</nav>