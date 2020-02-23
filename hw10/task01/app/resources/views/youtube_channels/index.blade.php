@extends('layouts.app')

@section('content')
    <h1>Youtube channels</h1>
    @if(count($channels))
        @foreach($channels as $channel)
            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <h3>
                    <a href="youtube_channels/{{$channel->id}}">{{$channel->title}}</a>
                    <span class="badge badge-danger">{{$channel->code}}</span>
                </h3>
            </div>
        @endforeach
    @endif
@endsection
