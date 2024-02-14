{{-- frontend lang --}}

@php
    $navEn = [
        'Connect' => 'Connect' ,
    ];
    $navAr = [
        'Connect' => 'كونكت' ,
    ];
    $nav = app()->isLocale('ar') ?  $navAr : $navEn;
@endphp
<header>
    <div class="bg-main grid grid-cols-2 items-center px-10 py-5  myBottomShadow relative z-20">
        <a href="/"><h1 class="text-white text-3xl justify-self-start">{{$nav['Connect']}}</h1></a>
        <div class="justify-self-end  border-[4px] hover:border-white border-main rounded-full  p-2 grid it-ce" onclick="navToggleFn()">
            <img src="{{ asset('assets/icons/bars.svg') }}" alt="bars" class=" w-[20px] h-[20px] ">
        </div>
    </div>
    <div id="navToggle" class="">
        @include('layouts.partials.navigation')
    </div>
    @include('layouts.partials.flashed-messages')
</header>

<script>
    var hide = false;
    var navToggleFn = () => {
        hide = !hide;
        if(hide){
            return $('#navToggle').hide()
        } else {
            return $('#navToggle').show()
        }
    }
</script>
