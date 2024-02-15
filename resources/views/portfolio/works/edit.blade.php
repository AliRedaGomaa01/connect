
<x-app-layout>
    <div class="grid it-ce m-10 p-10 myShadow rounded-xl vsm:w-[300px] sm:w-[600px] md:w-[800px]">
        <form action="{{route('works.update',$work['id'])}}" method="POST" class="w-full">
            @csrf
            @method('PATCH')
            <h3 class="text-center m-10">{{__('Edit')}}</h3>
            <div class="grid grid-cols-1 gap-5">
                <label for="workTypeInput">{{__('Type')}}</label>
                <select name="type" id="workTypeSelect" onchange="toggleCategoryFn()">
                    @foreach ($workTypes as $key => $value)
                        <option {{ $work['category'] === $key ? 'selected' : ($key === 'Other' ? 'selected' : '' ) }} value="{{$key}}"> {{$value}}</option>
                    @endforeach
                </select>
                @error('type')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <div class="grid grid-cols-1 gap-5" id="toggleCategorySelect">
                    <label for="workCategoryInput">{{__('Category')}}</label>
                    <input type="text" id="workCategoryInput" name="category" autocomplete="workCategoryInput" placeholder="{{__('Category')}}" value="{{$work['category'] ?? old('category') }}">
                    @error('category')
                        <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>
                <label for="workTitleInput">{{__('Title')}}</label>
                <input type="text" id="workTitleInput" name="title" autocomplete="workTitleInput" placeholder="{{__('Title')}}" value="{{$work['title'] ?? old('title') }}">
                @error('title')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <label for="workDescriptionInput">{{__('Description')}}</label>
                <textarea id="workDescriptionInput" name="description" cols="30" rows="10"  placeholder="{{__('Description')}}" >{{$work['description'] ?? old('description') }}</textarea>
                @error('description')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <label for="workPreviewURLInput">{{__('Preview URL')}}</label>
                <input type="text" id="workPreviewURLInput" name="url" autocomplete="workPreviewURLInput" placeholder="{{__('Preview URL')}}" value="{{$work['url'] ?? old('url') }}">
                @error('url')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <x-primary-button type="submit" class="justify-self-start my-5">{{__('Edit')}}</x-primary-button>
            </div>
        </form>
    </div>
    @section('scripts')
        <script>
            var toggleCategoryFn = function(){
                if($('#workTypeSelect').val() === 'Other'){
                    $('#toggleCategorySelect').show();
                } else {
                    $('#toggleCategorySelect').hide();
                    $('#workCategoryInput').val($('#workTypeSelect').val());
                }
            }
            toggleCategoryFn()
        </script>
    @endsection


</x-app-layout>