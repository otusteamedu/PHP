<?php
/**
 * @var $channels
 */
?>
<div class="card">
    <div class="card-body">
        <?php if (!empty($channels)) : ?>
        @foreach($channels as $channel)
        Канал "{{  $channel['name']}}" |
        Рейтинг: {{ $channel['rating'] }} <br>
        @endforeach
        <?php endif; ?>
    </div>
</div>
