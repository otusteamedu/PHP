@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Hi. I give u some statistic!</h1>
                <form action="/YouTubeStatistics" method="POST" class="mt-5" id="getYouTubeStatistic">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="text" name="channel-name" id="channel_name" class="form-control"
                                   placeholder="Введите название youtube канала" value="{{request('channel-name')}}"/>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Go</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @yield('statisticResult')
@endsection
