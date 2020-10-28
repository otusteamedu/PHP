@extends('youtube.youTubeStatistic')

@section('statisticResult')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Название канала: <b>{{ $data['channel_name'] }}</b></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">Количество лайков: <span class="text-success"><b>{{ $data['likes'] }}</b></span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">Количество дизлайков: <span
                    class="text-danger"><b>{{ $data['dislikes'] }}</b></span></div>
        </div>
    </div>
@endsection
