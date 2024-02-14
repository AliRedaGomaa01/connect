@php
    $messages = [[
        'condition' => session()->has('success'),
        'message' => session()->get('success'),
        'bgcolor' => 'bg-green-400 ',
        ],
        [
        'condition' => session()->has('danger'),
        'message' => session()->get('danger'),
        'bgcolor' => 'bg-red-400',
        ],
        [
        'condition' => session()->has('info'),
        'message' => session()->get('info'),
        'bgcolor' => 'bg-yellow-400',
        ]
    ];
@endphp

<div id="flashedMessages" class="">
    @foreach ($messages as $message)
        @if ($message['condition'])
            <div class="{{ $message['bgcolor']}} p-5 grid it-ce">{{ $message['message']}}</div>
        @endif
    @endforeach
</div>

<script>
    setTimeout(() => {
        $('#flashedMessages').remove();
    }, 3000);
</script>