<?php
/**
 * @var Airline $airline
 * @var Airplane $airplane
 */

use App\Model\Airline;
use App\Model\Airplane;

?>

<h1 class="h3"><?= $airline->getName() ?><span class="small"> (<?= $airline->getAbbreviation() ?>)</span></h1>
<p><?= $airline->getDescription() ?></p>

<h2 class="h4">Авиапарк</h2>
<ul class="list-group list-group-flush">
    <?php foreach ($airline->getAirplanes() as $airplane) :?>
        <li class="list-group-item">
            <h3 class="h5"><?= $airplane->getName() ?></h3>
            <p>Номер: <?= $airplane->getNumber() ?></p>
            <p>Посадочных мест: <?= $airplane->getSeatsCount() ?></p>
            <p>Дата постройки: <?= $airplane->getBuildDate()->format('d.m.Y') ?></p>
        </li>
    <?php endforeach; ?>
</ul>
