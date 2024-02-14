{{-- frontend lang --}}

@php
    $footerEn = [
        'footer' => 'Designed & Developed & Deployed by Ali Hussein © '.date('Y') ,
    ];
    $footerAr = [
        'footer' => 'تم تصميمه وتطويره ونشره بواسطة علي حسين © '.date('Y') ,
    ];
    $footer = app()->isLocale('ar') ?  $footerAr : $footerEn;
@endphp
<footer>
    <div class="bg-main px-10 py-5 w-[100vw] grid it-ce myTopShadow">
        <h1 class="text-white text-xl"> {{ $footer['footer'] }} </h1>    
    </div>
</footer>