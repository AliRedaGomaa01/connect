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
    $yourPageCond = auth()->check() 
        ? url()->current() == route('users.show',auth()->id())  || url()->current() == route('users.works',auth()->id()) || url()->current() == route('users.images',auth()->id())
        : false ;
@endphp
<nav>
    {{-- Guest Nav --}}
    @guest
        <div class="bg-white items-center p-10   myBottomShadow relative z-30">
            <ul class="grid grid-cols-4 gap-5 it-ce text-main">
                <li>
                    <a href="{{route('landing')}}" class="{{ route('landing') === url()->current() ? 'active' : '' }} hover:active">{{__("Home")}}</a>
                </li>
                <li>
                    <a href="{{route('login')}}" class="{{ route('login') === url()->current() ? 'active' : '' }} hover:active">{{__("Login")}}</a>
                </li>
                <li>
                    <a href="{{route('register')}}" class="{{ route('register') === url()->current() ? 'active' : '' }} hover:active">{{__("Register")}}</a>
                </li>
                <li>
                    <a href="{{$routes['lang']}}" class="{{ $routes['lang'] === url()->current() ? 'active' : '' }} hover:active">{{$nav['lang']}}</a>
                </li>
            </ul>
        </div>
    @endguest
    {{-- End of  Guest Nav --}}

    {{-- Auth Nav --}}  
        {{-- All pages nav --}}
        @auth
            <div class="bg-white items-center p-10   myBottomShadow relative z-30">
                <ul class="grid grid-cols-5 gap-5 it-ce text-main">
                    <li>
                        <a href="{{route('landing')}}" class="{{ route('landing') === url()->current() ? 'active' : '' }} hover:active">{{__("Home")}}</a>
                    </li>
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
            <div class="bg-white items-center p-10   myBottomShadow relative z-20">
                <ul class="grid  grid-cols-4 gap-5 it-ce text-main">
                    <li>
                        <a href="{{route('users.show',auth()->id())}}" class="{{ $yourPageCond ? 'active' : '' }} hover:active">{{__("Your Page")}}</a>
                    </li>
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
        @endauth

        {{-- Navs for specific pages --}}
        {{ $nav2 ?? '' }}
        {{ $nav3 ?? '' }}
    {{-- End of Auth  Nav --}}

</nav>