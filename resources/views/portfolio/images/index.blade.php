{{-- php variables --}}
@php
    # lang
    $indexEn = [
        'no images' => 'There are no images to show.' 
    ];
    $indexAr = [
        'no images' => 'لا توجد صور لعرضها.' 
    ];
    $index = app()->isLocale('ar') ?  $indexAr : $indexEn;
    # others
    $contentClasses = "p-10";
    $previousBtnCond =  $images['prev_page_url'] != true ;
    $nextBtnCond = $images['next_page_url'] != true ;
    $allBtnsCond = $images['last_page'] === 1 ;
@endphp
<x-app-layout>
    @slot('nav2')
        <x-user-nav :user="$user"></x-user-nav>
    @endslot
    <div class="grid it-ce  p-10 ">
        @if (isset($user) && $user->id == auth()->id() )
            <a href="{{route('images.create')}}" class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
                <x-primary-button class="justify-self-center">{{__('Add New')}}</x-primary-button>
            </a>
        @endif
        @if(empty($images['data']))
            <p class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5 text-center">{{$index['no images']}}</p>
        @endif
        @foreach ($images['data'] as $image)
            <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5 relative" x-data="{
                deleteFn: ($el)=>{if(confirm('{{json_encode(__('Are you sure?'))}}')){$el.submit()}}
            }">
                @if (auth()->id() == $image['user_id'])
                    <form  action="{{route('images.destroy',$image['id'])}}" method="post" x-on:click.prevent="deleteFn($el)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="absolute top-3 right-3 bg-red-600 rounded-full h-[2em] w-[2em] grid it-ce text-white font-[900]">X</button>
                    </form>
                @endif
                <a href="{{route('images.show',$image['id'])}}" class="justify-self-center">
                    <img src="{{asset('storage'.$image['path'])}}" alt="user image" >
                </a>
            </div>
        @endforeach

        {{-- buttons --}}
        <div class="grid grid-cols-3 it-ce w-full my-10 {{ $allBtnsCond ? 'hidden' : '' }}">
            <a href="{{$images['prev_page_url']}}" class="">
                <x-primary-button class="{{ $previousBtnCond ? 'hidden' : '' }}" > {{__('Previous')}} </x-primary-button>
            </a>
            <p class="justify-self-center {{$images['last_page'] === 1 ? 'hidden' : ''}}">{{$images['current_page']}} {{__('of')}} {{$images['last_page']}}</p >
            <a href="{{$images['next_page_url']}}" class="">
                <x-primary-button class="{{ $nextBtnCond ? 'hidden' : '' }}" > {{__('Next')}} </x-primary-button>
            </a>
        </div>
    </div>


</x-app-layout>