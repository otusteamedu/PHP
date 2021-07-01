<?php /** @var \App\Models\Article $channel */ ?>
<div class="">
<div class="alert alert-primary">
    <a href="{{route('channels.show', ['channel' => $channel->id])}}">
        <channel class="mb-3">
            <h2>{{$channel->title}}</h2>
        </channel>
    </a>
    <table width="100%">
        <tr>
            <td class="m-0">Всего лайков: <b>{{$channel->videos_sum_like_count}}</b></td>
            <td class="m-0">Всего дизлайков: <b>{{$channel->videos_sum_dislike_count}}</b></td>
            <td class="m-0">Всего просмотров: <b>{{$channel->view_count}}</b></td>
            <td class="m-0">Всего комментариев: <b>{{$channel->comment_count}}</b></td>
        </tr>
    </table>
</div>
<div class="card-body">
    <p class="m-0">{{$channel->description}}</p>
</div>
<div class="card-body">

</div>
</div>
