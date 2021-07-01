@forelse ($videos as $video)
    @include('videos.blocks.list.item')
@empty
    <p>No Videos found</p>
@endforelse
