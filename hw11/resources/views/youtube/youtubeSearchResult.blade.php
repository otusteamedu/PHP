<div id="youtubeSearchResult">
    @foreach($data as $channel_name => $channel)
        <div>
            <h3>Название канала: {{ $channel_name  }}</h3>
            @foreach($channel as $video)
                <div class="mt-3">
                    <div>Название видео: <b>{{$video->title}}</b></div>
                    <div>Количество лайков: <span class="text-success">{{$video->likes_count}}</span></div>
                    <div>Количество дизлайков: <span class="text-danger">{{$video->dislikes_count}}</span></div>
                    <div>Количество просмотров: {{$video->views_count}}</div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
