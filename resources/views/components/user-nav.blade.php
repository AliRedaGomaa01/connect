    @if( isset($user) && in_array(url()->current(),[route('users.show',$user['id']),route('users.works',$user['id']),route('users.images',$user['id'])]) )
        <div class="bg-white items-center p-10   myBottomShadow relative z-10">
            <ul class="grid grid-cols-1 vsm:grid-cols-3 gap-5 it-ce text-main">
                <li>
                    <a href="{{route('users.show',$user['id'])}}" class="{{ route('users.show',$user['id']) === url()->current() ? 'active' : '' }} hover:active">{{__("Main Info")}}</a>
                </li>
                <li>
                    <a href="{{route('users.works',$user['id'])}}" class="{{ route('users.works',$user['id']) === url()->current() ? 'active' : '' }} hover:active">{{__("User Works")}}</a>
                </li>
                <li>
                    <a href="{{route('users.images',$user['id'])}}" class="{{ route('users.images',$user['id']) === url()->current() ? 'active' : '' }} hover:active">{{__("User Photos")}}</a>
                </li>
            </ul>
        </div>
    @endif 