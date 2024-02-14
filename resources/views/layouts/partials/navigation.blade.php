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
    $routes = [
        'dashboard' => route('dashboard') ,
        'profile' => route('profile.edit') ,
        'logout' => route('logout') ,
        'lang' => app()->isLocale('ar') ? route(request()->route()->getName() , ['locale' => 'en'] )  : route(request()->route()->getName() , ['locale' => 'ar'] )  ,
    ] ;
@endphp
<nav>
    <div class="bg-white items-center p-10 gap-5  myBottomShadow relative z-10">
        <ul class="grid grid-cols-1 vsm:grid-cols-4 it-ce">
            @foreach ($nav as $key => $value)
                @if ($key == 'logout')
                    <form action="{{$routes[$key]}}" method="post">
                        @csrf
                        <li><button type="submit">{{$value}}</button></li>
                    </form>
                @else 
                    <li><a href="{{$routes[$key]}}">{{$value}}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
    {{ $nav2 ?? '' }}
    {{ $nav3 ?? '' }}
    {{ $nav4 ?? '' }}
</nav>