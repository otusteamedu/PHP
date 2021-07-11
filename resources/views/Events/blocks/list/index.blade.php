@forelse ($events as $event)
    @include('Events.blocks.list.item')
@empty
    <p>No Events found</p>
@endforelse
