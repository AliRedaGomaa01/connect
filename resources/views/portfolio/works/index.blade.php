{{-- php variables --}}
@php
    # lang
    $indexEn = [
        'preview work' =>  'click to visit url of previewing the work',
        'preview user' => 'click to visit url of previewing the owner profile' ,
        'no works' => 'There are no works to show.' 

    ];
    $indexAr = [
        'preview work' => 'قم بالنقر لزيارة رابط مطالعة العمل' ,
        'preview user' => 'قم بالنقر لزيارة رابط  الملف الشخصي للمالك' ,
        'no works' => 'لا توجد أعمال لعرضها.' 

    ];
    $index = app()->isLocale('ar') ?  $indexAr : $indexEn;
    # others
    $contentClasses = "p-10";
    $previousBtnCond =  $works['prev_page_url'] != true ;
    $nextBtnCond = $works['next_page_url'] != true ;
    $allBtnsCond = $works['last_page'] === 1 ;
@endphp
<x-app-layout>
    @slot('nav2')
        <x-user-nav :user="$user"></x-user-nav>
    @endslot
    <div class="grid it-ce  p-10 ">
        @if (isset($user) && $user->id == auth()->id() )
            <a href="{{route('works.create')}}" class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
                <x-primary-button class="justify-self-center">{{__('Add New')}}</x-primary-button>
            </a>
        @endif
        @if(empty($works['data']))
            <p class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5 text-center">{{$index['no works']}}</p>
        @endif
        @foreach ($works['data'] as $work)
            <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
                <h3>{{__('Category')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['category']}}</p>
                <h3>{{__('Title')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['title']}}</p>
                <h3>{{__('Description')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['description']}}</p>
                <h3>{{__('Preview URL')}}</h3>
                <a href="{{$work['url']}}" class="underline {{$contentClasses}}">{{$index['preview work']}}</a>
                <h3>{{__('Owner')}}</h3>
                <a href="{{route('users.show',$work['user_id'])}}" class="underline {{$contentClasses}}">{{$index['preview user']}}</a>
                <a href="{{route('works.show',$work['id'])}}" class="justify-self-center">
                    <x-primary-button class="">{{__('Show')}}</x-primary-button>
                </a>
            </div>
        @endforeach

        {{-- buttons --}}
        <div class="grid grid-cols-3 it-ce w-full my-10 {{ $allBtnsCond ? 'hidden' : '' }}">
            <a href="{{$works['prev_page_url']}}" class="">
                <x-primary-button class="{{ $previousBtnCond ? 'hidden' : '' }}" > {{__('Previous')}} </x-primary-button>
            </a>
            <p class="justify-self-center {{$works['last_page'] === 1 ? 'hidden' : ''}}">{{$works['current_page']}} {{__('of')}} {{$works['last_page']}}</p >
            <a href="{{$works['next_page_url']}}" class="">
                <x-primary-button class="{{ $nextBtnCond ? 'hidden' : '' }}" > {{__('Next')}} </x-primary-button>
            </a>
        </div>
    </div>

</x-app-layout>