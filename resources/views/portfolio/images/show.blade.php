{{-- php variables --}}
@php
    # lang
    $showEn = [
 
    ];
    $showAr = [
 
    ];
    $show = app()->isLocale('ar') ?  $showAr : $showEn;
    # others
    $contentClasses = "p-10";
@endphp
<x-app-layout>
    <div class="grid it-ce m-10 p-10 vsm:w-[300px] sm:w-[600px] md:w-[800px]">
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5 relative" x-data="{
            deleteFn($el){if(confirm('{{json_encode(__('Are you sure?'))}}')){$el.submit()}}
        }">
            @if (auth()->id() == $image['user_id'])
                <form  action="{{route('images.destroy',$image['id'])}}" method="post" x-on:click.prevent="deleteFn($el)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="absolute top-3 right-3 bg-red-600 rounded-full h-[2em] w-[2em] grid it-ce text-white font-[900]">X</button>
                </form>
            @endif
            <div  class="justify-self-center">
                <img src="{{asset('storage/'.$image['path'])}}" alt="user image" >
            </div>
        </div>
        @if ($image['user_id'] != auth()->id())
            <div class="" x-data="likesDiv">
                <div class=' px-10 py-5 grid it-ce' >
                    <span class="bg-main p-2 rounded-lg text-white">
                        <span  class="text-white  font-[900]" id='likesCount' x-text="likesCount" ></span> {{__('Likes')}}
                    </span>
                </div>
                @if (auth()->id() != $image['user_id'])
                    <div class="grid it-ce p-5">
                        <x-primary-button type='button' @click="toggleLike()" x-bind:class=" likeStatus == 'liked' && 'bg-red-600'"  > 
                            <span x-show="likeStatus == 'notLiked' " > <img src="{{asset('assets/icons/likes.svg')}}" alt="" class="w-[20px] h-[20px] ">  </span>
                            <span x-show="likeStatus == 'liked'" > <img src="{{asset('assets/icons/dislike.svg')}}" alt="" class="w-[20px] h-[20px] "> </span>
                        </x-primary-button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @section('scripts')
        <script>
            // ************ toggle like Fn
            document.addEventListener('alpine:init', () => {
                Alpine.data( "likesDiv" , () => ({
                    likeStatus:{!!json_encode( $image["likeStatus"] )!!},    
                    likesCount:{!!json_encode($image['likesCount'])!!},
                    red : this.likeStatus == 'liked',
                    toggleLike () {
                        axios.post(  {!!  json_encode(route('likes'))  !!}  ,
                            {
                            '_token' :   {!!  json_encode(csrf_token())  !!} ,
                            'user_id' :  {!!  json_encode(auth()->id())  !!} ,
                            'likeable_id' :  {!!  json_encode($image['id'])  !!} ,
                            'likeable_type' :  "Image" ,
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
