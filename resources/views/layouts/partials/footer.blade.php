{{-- frontend lang --}}

@php
    $footerEn = [
        'footer' => 'Designed & Developed & Deployed by <a href="https://alyhsn.com" class="underline" target="_blank"> Ali Hussein</a> © '.date('Y') ,
    ];
    $footerAr = [
        'footer' => 'تم تصميمه وتطويره ونشره بواسطة   <a href="https://alyhsn.com" class="underline" target="_blank"> علي حسين</a> © '.date('Y') ,
    ];
    $footer = app()->isLocale('ar') ?  $footerAr : $footerEn;
@endphp
<h1 class="text-white text-xl text-center"> {!! $footer['footer'] !!} </h1>    