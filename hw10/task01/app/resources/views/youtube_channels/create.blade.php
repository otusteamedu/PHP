@extends('layouts.app')

@section('content')
    <h1>Add channel</h1>

    {!! Form::open(['action' => 'YoutubeChannelsController@store', 'method' => 'POST']) !!}
    {{Form::bsText('title')}}
    {{Form::bsText('code')}}
    {{Form::bsSubmit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
