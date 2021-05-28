<?php
/**
 * @var string $error
 * @var string $email
 */
?>


<div class="row">
	<div class="col">
        <?php if ($error): ?>
			<div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
	</div>
</div>
<div class="row">
	<div class="col-lg-4 mx-auto">
		<form method="post">

			<h1 class="h3 mb-3 font-weight-normal">Вход</h1>

			<div class="mb-3">
				<label for="inputEmail">Электронный адрес</label>
				<input type="email" value="<?= $email ?>" name="email" id="inputEmail" class="form-control"
				       required
				       autofocus>
			</div>


			<div class="mb-3">
				<label for="inputPassword">Пароль</label>
				<input type="password" name="password" id="inputPassword" class="form-control" required>
			</div>

			<div class="mb-3">
				<button class="btn btn-lg btn-primary" type="submit">
					Вход
				</button>
			</div>

		</form>

	</div>
</div>

