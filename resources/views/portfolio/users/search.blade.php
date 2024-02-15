{{-- php variables --}}
@php
    # lang
    $searchEn = [

    ];
    $searchAr = [

    ];
    $search = app()->isLocale('ar') ?  $searchAr : $searchEn;
    # others
    $contentClasses = "p-10";
@endphp
<x-app-layout>
    <div class="grid it-ce m-10 p-10 vsm:w-[300px] sm:w-[600px] md:w-[800px]">
        {{-- Searching form --}}
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5">
            <form class="grid gap-5">
                @csrf
                <label>{{__('Search')}}</label>
                <input list="searchableUsersList" name="email" id="searchableUsersSelect" class="" autocomplete="off" onfocus="hideAll()">
                <datalist id="searchableUsersList">
                    @foreach ($searchable as $key => $value)
                        <option value="{{$key}}" >{{$value}}</option>
                    @endforeach
                </datalist>  
            </form>
            <x-primary-button class="justify-self-center" onclick="usersSearchResultFn()">{{__('Search')}}</x-primary-button>
        </div>

        {{-- Result if exist --}}
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5" style="display:none" id="hasUserResult">
            <h3>{{__('Name')}}</h3>
            <p class='{{$contentClasses}}'><span id="nameUsersSearchPage"></span></p>
            <h3>{{__('Email')}}</h3>
            <p class='{{$contentClasses}}'><span id="emailUsersSearchPage"></span></p>
            <a href=""  id="linkUsersSearchPage" class="underline justify-self-center {{$contentClasses}}">
                <x-primary-button class="">{{__('Show')}}</x-primary-button>
            </a>
        </div>
        <div class="myShadow rounded-xl m-5 p-5 w-[90%] grid gap-5" style="display:none" id="noUserResult">
            <div class="text-center">{{__('There is no results.')}}</div>
        </div>
    </div>

    <script>
        var hideAll = () => {
            $('#hasUserResult').hide()
            $('#noUserResult').hide()
        }
        var usersSearchResultFn = async () => {
            await axios.post("{{route('users.search.result')}}", {
                '_token' : "{{csrf_token()}}",
                'email' : $('#searchableUsersSelect').val()
            }).then((res) => {
                $('#nameUsersSearchPage').html(res.data.name);
                $('#emailUsersSearchPage').html(res.data.email);
                $('#linkUsersSearchPage').attr('href',res.data.link);
                $('#hasUserResult').show()
            } )
            .catch((err) => {
                $('#noUserResult').show()
            } ) 
        }
    </script>

</x-app-layout>