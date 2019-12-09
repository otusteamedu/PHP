@if (session()->has('success'))
    @php
        $msg = session('success')
    @endphp

    @if (is_array($msg))
        <div class="alert alert-success" role="alert">
            {{ $msg['text'] }}
            @if (array_key_exists('link', $msg))
                <a href="{{ $msg['link']['url'] }}">{{ $msg['link']['title'] }}</a>
            @endif
        </div>
    @else
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
@endif