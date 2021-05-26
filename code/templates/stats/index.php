<?php

/**
 * @var string $title
 * @var array $stats
 */

?>
<h1 class="h3"><?= $title ?></h1>

<div class="row mt-4">
	<div class="col-lg-2 mb-3">
		<label for="date-input" class="form-label">Выбрать дату</label>
		<input type="date" class="form-control" id="date-input">
	</div>
    <div class="col-12 mt-4">
	    <div id="chart-line"></div>
    </div>
</div>

<div class="row mt-4">
	<div class="col mt-4">
		<div id="chart-pie"></div>
	</div>
</div>
