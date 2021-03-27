<?php
/**
 * @var YoutubeChannel[] $channels
 * @var string $q
 * @var mixed $error
 */

use App\Model\YoutubeChannel;
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
    <h2 class="h4">
        <a class="list-group-item list-group-item-action" href="/channels/<?= $ch->getId() ?>">
            <?= $ch->getTitle() ?>
        </a>
    </h2>
<?php endforeach; ?>
</ul>
