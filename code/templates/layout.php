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
                        <a class="nav-link" href="/">YouTube</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/channels/top">Top</a>
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


</body>
</html>
