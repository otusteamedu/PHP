<?php

namespace App;

use App\Utils\DocParser;
use App\Utils\HtmlCreator;
use Exception;
use InvalidArgumentException;

require_once __DIR__ . '/../vendor/autoload.php';


$docParser = new DocParser();
$htmlCreator = new HtmlCreator();


$inputDir = __DIR__ . '/../docs';
$outputDir = __DIR__ . '/../public';
$files = getFiles($inputDir);

$counter = 1;
$titles = [];

foreach ($files as $doc) {

    try {
        $data = $docParser->parseFile(sprintf('%s/%s', $inputDir, $doc));
    } catch (Exception $e) {
        echo $e->getMessage();
        exit($e->getCode());
    }

    $outputFile = $counter++ . '.html';

    $htmlCreator->setOutputFile(sprintf('%s/%s', $outputDir, $outputFile));

    $title = $data['title'] . ' в Москве - Автосервис "Ровер"';
    $description = $data['title'] . ' в Москве. Бесплатная диагностика. Гарантия качества. Записаться - 8(495)150-70-69.';

    $isCreated = $htmlCreator->createHtml($title, $data['body'], $description, $data['title']);

    // если файл создан, добавить данные в массив titles, для создания index.html
    if ($isCreated) {
        echo sprintf('Создан файл %s, записано %d байт.%s', $outputFile, $isCreated, "\n");
        array_push($titles, ['title' => $data['title'], 'file' => $outputFile]);
    }
}

// create index.html
$body = '<h1>Список работ</h1>';
$body .= "\n";
$body .= "<ul style='list-style: none;'>";
foreach ($titles as $title) {
    $body .= sprintf(
        '%s<li style="padding: .5em;"><a href="%s">%s</a></li>',
        "\n\t",
        $title['file'],
        $title['title']
    );
}
$body .= "\n";
$body .= '</ul>';
$outputFile = 'index.html';
$htmlCreator->setOutputFile(sprintf('%s/%s', $outputDir, $outputFile));
$title = 'Список работ';
$isCreated = $htmlCreator->createHtml($title, $body, $title, $title);
if ($isCreated) {
    echo sprintf('Создан файл %s, записано %d байт.%s', $outputFile, $isCreated, "\n");
}


function getFiles($path)
{
    if (!is_dir($path)) {
        throw new InvalidArgumentException(sprintf('"%s" - is not directory.', $path));
    }
    $files = scandir($path);
    $docs = [];
    foreach ($files as $file) {
        if (preg_match('/.*\.docx$/', $file)) {
            array_push($docs, $file);
        }
    }
    return $docs;
}

