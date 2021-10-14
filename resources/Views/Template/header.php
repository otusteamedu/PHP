<!DOCTYPE HTML>

<html>
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    <noscript><link rel="stylesheet" href="/assets/css/noscript.css"/></noscript>
</head>
<body>
<div>
    <div id="header" class="header">
        <div>
        <span><b><?php echo $user->getRole() . ": " . $user->getFirstName() . " " . $user->getLastName();?></b></span>
        <div class="form-group">
            <form action="/login/logout" method="post">
                <button type="submit">Выйти</button>
            </form>
        </div>
        </div>
    </div>
