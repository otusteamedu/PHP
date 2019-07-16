<h1>TOP 10</h1>
<table>
<tr>
    <td>Канал</td>
    <td>Лайков</td>
    <td>Дизлайков</td>
    <td>Всего просмотров</td>
</tr>
<?php

$channelsList = $asset['channelsList'];

foreach ($channelsList as $document) {
?>
<tr>
    <td><a href="https://www.youtube.com/channel/<?=$document->channelId?>" target="_blank"><?=$document->channelTitle?></a></td>
    <td><?=$document->channelLikes?></td>
    <td><?=$document->channelDislikes?></td>
    <td><?=$document->channelViews?></td>
</tr>
<?php
}
?>
</table>