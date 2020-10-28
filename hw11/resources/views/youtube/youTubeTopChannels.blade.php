@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Топ каналов по соотношению лайков к дизлайкам</h1>
            </div>
        </div>
        @foreach($data as $channel_name => $channel)
            <div class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <h4>Название канала: <span><b>{{ $channel_name }}</b></span></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">Количество лайков: <span
                            class="text-success"><b>{{ $channel['likes'] }}</b></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">Количество дизлайков: <span
                            class="text-danger"><b>{{ $channel['dislikes'] }}</b></span></div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
