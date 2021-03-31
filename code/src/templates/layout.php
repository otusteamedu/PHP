<?php
/**
 * @var string $title
 * @var string $content
 * @var array $scripts
 * @var string $style
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="chrome=1, IE=edge">
    <link type="text/css" href="<?= $style ?>" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container-fluid mx-md-5">
            <a class="navbar-brand" href="/"><?= $title ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/validation">Validation</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Elastic
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/channels">Channels</a></li>
                            <li><a class="dropdown-item" href="/channels/top">Top</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/event">Redis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/airlines">Orm</a>
                    </li>

                </ul>
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
<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
        <script src="/js/<?= $script ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
