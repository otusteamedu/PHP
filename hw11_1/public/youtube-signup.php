<?php

use App\Services\YouTubeAuth;

session_start();

if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
    die();
}

chdir(dirname(__DIR__));

$container = require getcwd() . '/config/container.php';

/** @var YouTubeAuth $authService */
$authService = $container[YouTubeAuth::class];

$redirectUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$authService->setRedirectUri($redirectUri);

if (isset($_GET['code'])) {
    $authService->fetchToken($_GET['code']);
    $_SESSION['success'] = 'Access token saved.';
    header("Location: $redirectUri", true);
    die();
}

try {
    $authService->initToken();
    echo 'Access token initialized.';
    die();
} catch (RuntimeException $e) {
    $authUrl = $authService->createAuthUrl($redirectUri);
    header("Location: $authUrl");
    die;
}
