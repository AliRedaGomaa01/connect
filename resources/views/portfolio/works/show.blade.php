{{-- php variables --}}
@php
    # lang
    $showEn = [
        'preview work' =>  'click to visit url of previewing the work',
        'preview user' => 'click to visit url of previewing the owner profile' ,
    ];
    $showAr = [
        'preview work' => 'قم بالنقر لزيارة رابط مطالعة العمل' ,
        'preview user' => 'ثم بالنقر لزيارة رابط  الملف الشخصي للمالك' ,
    ];
    $show = app()->isLocale('ar') ?  $showAr : $showEn;
    # others
    $isOwner = auth()->user()->id == $work['user_id'];
    $contentClasses = "p-10";
@endphp
<x-app-layout>
    <div class="grid it-ce m-10 p-10 vsm:w-[300px] sm:w-[600px] md:w-[800px]">
            <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
                <h3>{{__('Category')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['category']}}</p>
                <h3>{{__('Title')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['title']}}</p>
                <h3>{{__('Description')}}</h3>
                <p class='{{$contentClasses}}'>{{$work['description']}}</p>
                <h3>{{__('Preview URL')}}</h3>
                <a href="{{$work['url']}}" class="underline {{$contentClasses}}">{{$show['preview work']}}</a>
                <h3>{{__('Owner')}}</h3>
                <a href="{{route('users.show',$work['user_id'])}}" class="underline {{$contentClasses}}">{{$show['preview user']}}</a>
            </div>

        {{-- buttons --}}
        <div class="grid grid-cols-2 it-ce w-full my-10">
            <a href="{{route('works.edit',$work['id'])}}" class="">
                <x-primary-button class="{{ !$isOwner ? 'hidden' : '' }}" > {{__('Update')}} </x-primary-button>
            </a>
            <form  action="{{route('works.destroy',$work['id'])}}" id="deleteWorkForm"  method="POST">
                @csrf
                @method('DELETE')
                <x-primary-button type='button' onclick="submitDeleteWorkForm()" class="{{ !$isOwner ? 'hidden' : '' }} bg-red-600" > {{__('Delete')}} </x-primary-button>
            </form >
        </div>
        <a href="{{route('works.create')}}" class="">
            <x-primary-button class="">{{__('Add New')}}</x-primary-button>
        </a>
    </div>
</x-app-layout>

<script>
    function submitDeleteWorkForm() {
        var confirmed = confirm("{{__('Are you sure?')}}");
        if(confirmed){
            return $('#deleteWorkForm').submit();
        } else {
            return false;
        }
    }
</script>