<?php
/**
 * @var string $title
 * @var string $app_name
 * @var string $content
 * @var array $scripts
 * @var array $styles
 * @var User $user
 */

use App\Entity\User;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="chrome=1, IE=edge">
	<?php foreach ($styles as $style): ?>
	<link type="text/css" href="/css/<?= $style ?>" rel="stylesheet">
	<?php endforeach; ?>

</head>
<body>
<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid mx-md-5">
            <a class="navbar-brand" href="/"><?= $app_name ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="/task-one">Задание 1</a>-->
<!--                    </li>-->

                </ul>

	            <?php if ($user): ?>
	            <div class="ml-lg-5 dropdown">
		            <a class="dropdown-toggle removecarret" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
			            <img src="/img/user.png" width="40" height="40" class="rounded-circle">
		            </a>

		            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
			            <li><a class="dropdown-item" href="/profile">Профиль</a></li>
			            <li><hr class="dropdown-divider"></li>
			            <li><a class="dropdown-item" href="/logout">Выход</a></li>
		            </ul>
	            </div>
	            <?php else: ?>
	            <a class="btn" href="/login">Вход</a>
	            <?php endif; ?>

            </div>
        </div>

    </nav>
</header>
<main>
    <div class="container my-4">
        <?= $content ?>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
<scripts src="/js/common.js"></scripts>
<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
        <script type="application/javascript" src="<?= $script ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
