@extends('layouts.app')

@section('content')

    <a href="/channel/{{$channel->id}}" class="btn btn-primary">Back</a>

    <h1>Edit channel</h1>

    {!! Form::open(['action' => ['YoutubeChannelsController@update', $channel->id], 'method' => 'POST']) !!}
    {{Form::bsText('title', $channel->title)}}
    {{Form::bsTextArea('code', $channel->code)}}
    {{Form::bsSubmit('Save', ['class' => 'btn btn-primary'])}}
    {{Form::hidden('_method', 'PUT')}}
    {!! Form::close() !!}

@endsection
