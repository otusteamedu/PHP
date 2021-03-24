<?php
/**
 * @var YouTubeChannel[] $channels
 * @var string $q
 * @var mixed $error
 */

use App\Model\YouTubeChannel;


?>
<h1 class="h3 visually-hidden">Поиск канала</h1>

<form method="get">
    <div class="row mb-3">
        <div class="col col-lg-11 mx-auto">
            <input type="text" class="form-control" name="q" placeholder="Строка запроса" value="<?=$q?>">
        </div>
        <div class="col col-lg-1 mx-auto">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>

<div class="row">
    <?if ($error) print_r($error) ?>
</div>

<ul class="list-group list-group-flush">
<?php foreach ($channels as $ch) :?>

    <li class="list-group-item">
        <h3><a href="/<?=$ch->getId()?>"<?= $ch->getTitle() ?></a></h3>
        <p><?= $ch->getDescription() ?></p>
    </li>
<?php endforeach; ?>
</ul>
