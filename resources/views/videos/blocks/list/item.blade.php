<?php /** @var \App\Models\Video $video */ ?>

<a href="{{ route('videos.show', ['video' => $video->id]) }}">
    <channel class="mb-3">
        <h2>{{$video->title }}</h2>
        <p class="m-0">{{$video->description}}</p>
        <div class="alert-info m-0" style="width: 560px">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$video->youtube_video_id}}" frameborder="0" allowfullscreen>
            </iframe>
            <table width="100%">
                <tr>
                    <td class="m-0">лайков: <b>{{$video->like_count}}</b></td>
                    <td class="m-0" align="right">дизлайков: <b>{{$video->dislike_count}}</b></td>
                </tr>
            </table>
        </div>
        <div>
            @foreach ($video->tags as $tag)
                <span class="badge badge-light">{{$tag}}</span>
            @endforeach
        </div>
    </channel>
</a>
