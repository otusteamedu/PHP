<?php
/* @var Airline[] $airlines */

use App\Model\Airline;

?>

<h1 class="h3 mb-3">Airlines</h1>

<div class="row mt-3">
    <div class="col">
        <ul class="list-group list-group-flush">
            <?php foreach ($airlines as $airline) : ?>
                <h2 class="h4">
                    <a class="list-group-item list-group-item-action" href="/airlines/<?= $airline->getId() ?>">
                        <?= $airline->getName() ?>
                    </a>
                </h2>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
