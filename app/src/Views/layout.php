<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title> <?= $title ?? 'Test project'?></title>
</head>
<body>
<div class="container">
    <header class="mt-3 mb-3">
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
                <a class="nav-link <?= $currentUrl === '/' ? 'active' : '' ?>"  href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentUrl === '/channels/parse' ? 'active' : '' ?>" href="/channels/parse">Index Channels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentUrl === '/channels' ? 'active' : '' ?>" href="/channels">Search Channels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentUrl === '/videos' ? 'active' : '' ?>" href="/videos">Search Videos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentUrl === '/events' ? 'active' : '' ?>" href="/events">Events</a>
            </li>
        </ul>
    </header>

    <?= $content ?? '' ?>
</div>
</body>
</html>
