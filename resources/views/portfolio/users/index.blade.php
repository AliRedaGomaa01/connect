{{-- php variables --}}
@php
    # lang
    $indexEn = [


    ];
    $indexAr = [

    ];
    $index = app()->isLocale('ar') ?  $indexAr : $indexEn;
    # others
    $contentClasses = "p-10";
    $previousBtnCond =  $users['prev_page_url'] != true ;
    $nextBtnCond = $users['next_page_url'] != true ;
    $allBtnsCond = $users['last_page'] === 1 ;
@endphp
<x-app-layout>
    <x-container>
        <a href="{{route('users.search')}}" class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
            <x-primary-button class="justify-self-center">{{__('Search Page')}}</x-primary-button>
        </a>
        @foreach ($users['data'] as $user)
            <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
                <h3>{{__('Name')}}</h3>
                <p class='{{$contentClasses}}'>{{$user['name']}}</p>
                <h3>{{__('Email')}}</h3>
                <p class='{{$contentClasses}}'>{{$user['email']}}</p>
                <a href="{{route('users.show',$user['id'])}}" class="underline justify-self-center {{$contentClasses}}"><x-primary-button class="">{{__('Show')}}</x-primary-button></a>
            </div>
        @endforeach
        {{-- buttons --}}
        <div class="grid grid-cols-3 it-ce w-full my-10 {{ $allBtnsCond ? 'hidden' : '' }}">
            <a href="{{$users['prev_page_url']}}" class="">
                <x-primary-button class="{{ $previousBtnCond ? 'hidden' : '' }}" > {{__('Previous')}} </x-primary-button>
            </a>
            <p class="justify-self-center {{$users['last_page'] === 1 ? 'hidden' : ''}}">{{$users['current_page']}} {{__('of')}} {{$users['last_page']}}</p >
            <a href="{{$users['next_page_url']}}" class="">
                <x-primary-button class="{{ $nextBtnCond ? 'hidden' : '' }}" > {{__('Next')}} </x-primary-button>
            </a>
        </div>
    </x-container>
</x-app-layout>