
<x-app-layout>
    <div class="grid it-ce m-10 p-10 myShadow rounded-xl vsm:w-[300px] sm:w-[600px] md:w-[800px]">
        <form action="{{route('images.store')}}" method="POST" class="w-full">
            @csrf
            <h3 class="text-center m-10">{{__('Add New')}}</h3>
            <div class="grid grid-cols-1 gap-5">
                <label for="imageFileInput">{{__('Image')}}</label>
                <input type="file" id="imageFileInput" name="image" autocomplete="imageFileInput" placeholder="{{__('Image')}}" value="{{ old('image') }}">
                @error('image')
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