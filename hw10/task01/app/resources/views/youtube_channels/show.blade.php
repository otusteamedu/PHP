@extends('layouts.app')

@section('content')
    <a class="btn btn-primary btn-lg active" href="/">Go Back</a>

    <h1>
        {{$channel->title}}
        <span class="badge badge-danger">{{$channel->code}}</span>
    </h1>
    <hr/>
    <p>todo statistics</p>
    <br/>
    <br/>
    <a href="/youtube_channels/{{$channel->id}}/edit" class="btn btn-primary">Edit</a>


    {!! Form::open(['action' => ['YoutubeChannelsController@destroy', $channel->id], 'method' => 'POST', 'class' => 'float-right']) !!}
    {{Form::bsSubmit('delete', ['class' => 'btn btn-danger'])}}
    {{Form::hidden('_method', 'DELETE')}}
    {!! Form::close() !!}

@endsection
