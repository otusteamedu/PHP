@extends('layouts.app')
@section('content')
    <?php /** @var \App\Models\Channel $channel */ ?>
    <div class="container">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">
                    {{$channel->title }}
                </h1>
                <h4>
                    <p class="text-justify">{{$channel->description}}</p>
                </h4>
                <table width="100%">
                    <tr>
                        <td class="m-0">Общее количество лайков: <b>{{$channel->likes}}</b></td>
                        <td class="m-0">Общее количество дизлайков: <b>{{$channel->dislikes}}</b></td>
                        <td class="m-0">Общее количество просмотров: <b>{{$channel->views}}</b></td>
                        <td class="m-0">Общее количество комментариев: <b>{{$channel->comments}}</b></td>
                    </tr>
                </table>
                <p class="lead">
                <div>
                    @include('videos.blocks.list.index')
                </div>
                </p>
            </div>
        </div>
    </div>
@stop
