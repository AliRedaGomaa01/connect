{{-- php variables --}}
@php
    # lang
    $showEn = [
        'following' => 'This user is following',
        'followed' =>  'This use has been followed by', 
        "other users" => "other users. Click to see.",
    ];
    $showAr = [
        'following' => 'هذا المستخدم يتابع',
        'followed' =>  'هذا المستخدم تتم متابعته بواسطة', 
        "other users" => "مستخدمين آخرين. انقر للعرض.",
    ];
    $show = app()->isLocale('ar') ?  $showAr : $showEn;
    # others
    $contentClasses = "p-10";
@endphp
<x-app-layout>
    @slot('nav2')
        <x-user-nav :user="$user"></x-user-nav>
    @endslot
    <div class="grid it-ce m-10 p-10 vsm:w-[300px] sm:w-[600px] md:w-[800px]">
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
            <h3>{{__('Name')}}</h3>
            <p class='{{$contentClasses}}'>{{$user['name']}}</p>
            <h3>{{__('Email')}}</h3>
            <p class='{{$contentClasses}}'>{{$user['email']}}</p>
            <h3>{{__('Bio')}}</h3>
            <p class='{{$contentClasses}}'>{{$user['bio']  ?? "---"}}</p>
            <h3>{{__('CV Link')}}</h3>
            <a class='{{$contentClasses}} underline' href="{{$user['cv_link']??'/#'}}" target="_blank">{{__('CV Link')}} </a>
            <h3>{{__('Follows')}}</h3>
            <a class=' px-10 py-5 underline' href="{{route('follows',[ $user['id'] , 'following' ] ) }}" target="_blank">{{$show['following'] . ' ' . $followingCount . ' ' . $show['other users'] }} </a>
            <a class=' px-10 py-5 underline' href="{{route('follows',[ $user['id'] , 'followed' ] ) }}" target="_blank">{{ $show['followed'] . ' ' . $followedByCount . ' ' . $show['other users'] }} </a>
            <div id="followBtnDiv" class="grid">
                <x-primary-button id="followBtn" class="justify-self-center" onclick="togglefollowServer()">{{__('Follow')}}</x-primary-button>
                <x-primary-button id="unfollowBtn" class="justify-self-center bg-red-600" onclick="togglefollowServer()">{{__('Unfollow')}}</x-primary-button>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            var followBtnDiv = $('#followBtnDiv');
            var followBtn = $('#followBtn');
            var unfollowBtn = $('#unfollowBtn');
            var followStatus = {!! json_encode($followStatus) !!} ;
            var toggleFollowStatus = () => {
                return followStatus = followStatus == 'unfollowing' ? 'following' : (followStatus == 'following' ? 'unfollowing' : '');
            }
            var toggleFollowBtn = () => { 
                if ({!!  json_encode($user["id"] === auth()->id())  !!}) {
                    followBtnDiv.html("");
                } else if (followStatus == 'following')  {
                    followBtnDiv.html(unfollowBtn);
                } else if (followStatus == 'unfollowing'){
                    followBtnDiv.html(followBtn);
                }
            }
            var togglefollowServer = async () => {
                await axios.post(  {!!  json_encode(route('follows.store'))  !!}  ,
                    {
                    '_token' :   {!!  json_encode(csrf_token())  !!} ,
                    'followed_id' :  {!!  json_encode($user["id"])  !!} ,
                    'following_id' :  {!!  json_encode(auth()->id())  !!} ,
                 }
                ).then((res) => {
                    toggleFollowStatus();
                    toggleFollowBtn();
                }).catch((err)=>{alert(err)})
            }
            toggleFollowBtn();
        </script>
    @endsection

</x-app-layout>