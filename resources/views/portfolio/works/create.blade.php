
<x-app-layout>
    <div class="grid it-ce  p-10 myShadow rounded-xl ">
        <form action="{{route('works.store')}}" method="POST" class="w-full">
            @csrf
            <h3 class="text-center m-10">{{__('Add New')}}</h3>
            <div class="grid grid-cols-1 gap-5">
                <label for="workTypeInput">{{__('Type')}}</label>
                <select name="type" id="workTypeSelect" onchange="toggleCategoryFn()">
                    @foreach ($workTypes as $key => $value)
                        <option value="{{$key}}"> {{$value}}</option>
                    @endforeach
                </select>
                @error('type')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <div class="grid grid-cols-1 gap-5" id="toggleCategorySelect">
                    <label for="workCategoryInput">{{__('Category')}}</label>
                    <input type="text" id="workCategoryInput" name="category" autocomplete="workCategoryInput" placeholder="{{__('Category')}}" value="{{ old('category') }}">
                    @error('category')
                        <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>
                <label for="workTitleInput">{{__('Title')}}</label>
                <input type="text" id="workTitleInput" name="title" autocomplete="workTitleInput" placeholder="{{__('Title')}}">
                @error('title')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <label for="workDescriptionInput">{{__('Description')}}</label>
                <textarea id="workDescriptionInput" name="description" cols="30" rows="10"  placeholder="{{__('Description')}}"></textarea>
                @error('description')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <label for="workPreviewURLInput">{{__('Preview URL')}}</label>
                <input type="text" id="workPreviewURLInput" name="url" autocomplete="workPreviewURLInput" placeholder="{{__('Preview URL')}}">
                @error('url')
                    <div class="text-red-600">{{$message}}</div>
                @enderror
                <x-primary-button type="submit" class="justify-self-start my-5">{{__('Add')}}</x-primary-button>
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