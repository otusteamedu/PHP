<?php

/**
 * @var string $error
 * @var string $success
 * @var string $dateStart
 * @var string $dateEnd
 */

?>

<h1 class="h3">Сведения из банка</h1>

<div class="row">
	<div class="col">
        <?php if ($error): ?>
		<div class="alert alert-danger"><?= $error ?></div>
        <?php elseif ($success): ?>
			<div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
	</div>
</div>

<div class="row">
	<p>Для получения сведения об операциях выберите нужные даты</p>
	<div class="col-lg-4">
		<form method="post">

			<div class="mb-3">
				<label for="inputDateStart">Начальная дата</label>
				<input type="date" min="<?= $dateStart ?>" max="<?= date('Y-m-d') ?>" value="<?= $dateStart ?>"
				       name="date-start" id="inputDateStart" class="form-control">
			</div>

			<div class="mb-3">
				<label for="inputDateEnd">Конечная дата</label>
				<input type="date" max="<?= $dateEnd ?>" value="<?= $dateEnd ?>"
				       name="date-end" id="inputDateEnd" class="form-control">
			</div>

			<div class="mb-3">
				<button class="btn btn-lg btn-primary" type="submit">
					Получить
				</button>
			</div>

		</form>

	</div>
</div>

