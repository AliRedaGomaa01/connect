{{-- one time used php variables --}}
@php
    # lang
    $landingEn = [
        'header' => 'Connect Project' ,
        'body' => 'It\'s a project made by me - Ali Hussein - which proofs that I know how to use the technical skills that mentioned in my CV.' ,
        'body2' => 'You can register and test the application.' ,
        'body3' => 'Don\'t hesitate to contact me anytime.' ,
        'body4' => 'You can visit my website to get all info about me.' ,
        'key' => 'value' ,
    ];
    $landingAr = [
        'header' => 'مشروع كونكت' ,
        'body' => 'هو مشروع تم بواسطتي - على حسين- والذي يثبت أنني أستطيع تطبيق المهارات التقنية المذكورة في سيرتي الذاتية.' ,
        'body2' => 'بإمكانك التسجيل كمستخدم جديد واختبار التطبيق.' ,
        'body3' => 'لا تتردد في التواصل معي في أي وقت.' ,
        'body4' => 'يمكنك زيارة موقعي للحصول  على كافة المعلومات عني.' ,
        'key' => 'القيمة' ,
    ];
    $landing = app()->isLocale('ar') ?  $landingAr : $landingEn;
    $isEn = app()->isLocale('en');
    # others
    $contentClasses = "text-main";
@endphp
<x-guest-layout>
    <div class="grid gap-5 text-center">
        <h1 class="text-center text-main text-3xl font-[900] p-5 rounded-xl ">{{$landing['header']}}</h1>
        <p class="{{$contentClasses}}">{{$landing['body']}}</p>
        <p class="{{$contentClasses}}">
            {{ $isEn 
            ? 'It\'s a project where you can publish your achievements that may benifit others.' 
            : 'من خلاله يمكنك مشاركة انجازاتك التي قد تنفع الآخرين.' }}
        </p>
        <p class="">
            {{ $isEn 
            ? 'Also, you can follow others and like their achievements & their photos.' 
            : 'أيضا يمكنك متابعة الآخرين والاعجاب بإنجازاتهم وصورهم.' }}
        </p>
        <p class="{{$contentClasses}}">{{$landing['body2']}}</p>
        <p class="{{$contentClasses}}">{{$landing['body3']}}</p>
        <p class="{{$contentClasses}}">{{$landing['body4']}}</p>
        <a href="https://aligh.net" class="underline" target="_blank">{{$isEn?'My Website Url':'رابط موقعي الشخصي'}}</a>
        <a href="https://github.com/AliRedaGomaa01/connect" class="underline" target="_blank">{{$isEn ? 'Github Url' : "رابط Github"}}</a>
    </div>
</x-guest-layout>