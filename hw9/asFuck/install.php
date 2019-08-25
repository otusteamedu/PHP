<?php

$statement = getStatementForLastCommandExtraction();

if ($statement === null) {
    echo "ERROR: lastCommandExtractor not found" . PHP_EOL;
    die(1);
}

$bashrcLocation = $_SERVER['HOME'] . '/.bashrc';
$installationData = "# AS FUCK DATA START" . PHP_EOL .
    "function runAsFuck { php " . __DIR__ . "/asFuck.php  --command=\"$($statement)\"; }" . PHP_EOL .
    "function fuck () { php " . __DIR__ . "/asFuck.php -a ; }" . PHP_EOL .
    "PROMPT_COMMAND='runAsFuck'" . PHP_EOL .
    "# AS FUCK DATA END" . PHP_EOL;

if (isInstalled($bashrcLocation, $installationData)) {
    echo "AsFuck is already installed" . PHP_EOL;
    die(1);
}

$status = addEntryToBashrc($bashrcLocation, $installationData);

if ($status && isInstalled($bashrcLocation, $installationData)) {
    echo "AsFuck has been successfully installed" . PHP_EOL;
    die(0);
}

function addEntryToBashrc(string $bashrcLocation, string $entry): bool
{
    return file_put_contents($bashrcLocation, PHP_EOL . $entry . PHP_EOL, FILE_APPEND);
}

function isInstalled(string $bashrcLocation, string $installationData): bool
{
    if (strpos(file_get_contents($bashrcLocation), $installationData) !== false) {
        return true;
    }

    return false;
}

function getStatementForLastCommandExtraction(): ?string
{
    $pathToLastCommandExtractor = __DIR__ . '/lastCommandExtractor';

    if (file_exists($pathToLastCommandExtractor)) {
        return file_get_contents($pathToLastCommandExtractor);
    }

    return null;
}