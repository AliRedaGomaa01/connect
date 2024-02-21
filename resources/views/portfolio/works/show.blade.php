{{-- php variables --}}
@php
    # lang
    $showEn = [
        'preview work' =>  'click to visit url of previewing the work',
        'preview user' => 'click to visit url of previewing the owner profile' ,
        'likes' => 'Likes count is : ' ,
    ];
    $showAr = [
        'preview work' => 'قم بالنقر لزيارة رابط مطالعة العمل' ,
        'preview user' => 'ثم بالنقر لزيارة رابط  الملف الشخصي للمالك' ,
        'likes' => 'عدد الإعجابات  :' ,
    ];
    $show = app()->isLocale('ar') ?  $showAr : $showEn;
    # others
    $contentClasses = "p-10";
@endphp
<x-app-layout>
    <x-container>
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
            <h3>{{__('Category')}}</h3>
            <p class='{{$contentClasses}}'>{{$work['category']}}</p>
            <h3>{{__('Title')}}</h3>
            <p class='{{$contentClasses}}'>{{$work['title']}}</p>
            <h3>{{__('Description')}}</h3>
            <p class='{{$contentClasses}}'>{{$work['description']}}</p>
            <h3>{{__('Preview URL')}}</h3>
            <div class="">
                <a href="{{$work['url']}}" class="underline {{$contentClasses}}">{{$show['preview work']}}</a>
            </div>
                <h3>{{__('Owner')}}</h3>
            <div class="">
                <a href="{{route('users.show',$work['user_id'])}}" class="underline {{$contentClasses}}">{{$show['preview user']}}</a>
            </div>
            {{-- Like info --}}
            <h3>{{__('Likes')}}</h3>
            <div class="" x-data="likesDiv">
                <div class=' px-10 py-5' >
                    {{$show['likes'] . ' ' }} 
                        <span  class="text-white bg-main p-2 rounded-lg font-[900]" id='likesCount' x-text="likesCount" ></span>
                </div>
                {{-- buttons --}}
                @if (auth()->id() != $work['user_id'])
                    <div class="grid it-ce p-5">
                        <x-primary-button type='button' @click="toggleLike()" x-bind:class=" likeStatus == 'liked' && 'bg-red-600'"  > 
                            <span x-show="likeStatus == 'notLiked' " >  {{__('Like')}}  </span>
                            <span x-show="likeStatus == 'liked'" > {{__('Not Like')}} </span>
                        </x-primary-button>
                    </div>
                @endif
            </div>
        </div>
        @if (auth()->id() == $work['user_id'])
            <div class="grid grid-cols-2 it-ce w-full my-10">
                <a href="{{route('works.edit',$work['id'])}}" class="">
                    <x-primary-button class="" > {{__('Update')}} </x-primary-button>
                </a>
                <form  action="{{route('works.destroy',$work['id'])}}" id="deleteWorkForm"  method="POST">
                    @csrf
                    @method('DELETE')
                    <x-primary-button type='button' onclick="submitDeleteWorkForm()" class=" bg-red-600" > {{__('Delete')}} </x-primary-button>
                </form >
            </div>
        @endif
        {{-- end of buttons --}}
    </x-container>
    @section('scripts')
        <script>
            // ************* deleteing work Fn 
            function submitDeleteWorkForm() {
                var confirmed = confirm("{{__('Are you sure?')}}");
                if(confirmed){
                    return $('#deleteWorkForm').submit();
                } else {
                    return false;
                }
            }
            // ************ toggle like Fn
            document.addEventListener('alpine:init', () => {
                Alpine.data( "likesDiv" , () => ({
                    likeStatus:{!!json_encode( $work["likeStatus"] )!!},    
                    likesCount:{!!json_encode($work['likesCount'])!!},
                    red : this.likeStatus == 'liked',
                    toggleLike () {
                        axios.post(  {!!  json_encode(route('likes'))  !!}  ,
                            {
                            '_token' :   {!!  json_encode(csrf_token())  !!} ,
                            'user_id' :  {!!  json_encode(auth()->id())  !!} ,
                            'likeable_id' :  {!!  json_encode($work['id'])  !!} ,
                            'likeable_type' :  "Work" ,
                            }
                        ).then((res) => {
                            this.likeStatus = res.data.status;
                            this.likesCount = res.data.count;
                        }).catch((err)=>{console.log(err)})
                    },
                }));
            })
        </script>
    @endsection
</x-app-layout>

