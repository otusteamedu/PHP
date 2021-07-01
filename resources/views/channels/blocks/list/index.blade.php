@forelse ($channels as $channel)
    @include('channels.blocks.list.item')
@empty
    <p>No Channels found</p>
@endforelse
