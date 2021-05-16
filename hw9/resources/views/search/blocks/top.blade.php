<?php
/**
 * @var $channels
 */
?>
<div class="card">
    <div class="card-body">
        @if (!empty($channels))
            @foreach($channels as $channel)
                <p>
                    Канал "{{  $channel['name']}}" |
                    Рейтинг: {{ $channel['rating'] }} <br>
                </p>
            @endforeach
        @endif
    </div>
</div>
