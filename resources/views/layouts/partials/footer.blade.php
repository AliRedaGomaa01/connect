{{-- frontend lang --}}

@php
    $footerEn = [
        'footer' => 'Designed & Developed & Deployed by <a href="https://aligh.net" class="underline" target="_blank"> Ali Hussein</a> © '.date('Y') ,
    ];
    $footerAr = [
        'footer' => 'تم تصميمه وتطويره ونشره بواسطة   <a href="https://aligh.net" class="underline" target="_blank"> علي حسين</a> © '.date('Y') ,
    ];
    $footer = app()->isLocale('ar') ?  $footerAr : $footerEn;
@endphp
<footer>
    <div class="bg-main px-10 py-5 w-full grid it-ce myTopShadow">
        <h1 class="text-white text-xl text-center"> {!! $footer['footer'] !!} </h1>    
    </div>
    
</footer>