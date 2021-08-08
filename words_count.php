<?php

use Counters\WordsCounter;

require_once __DIR__ . '/vendor/autoload.php';
echo "<pre>";
$file = $_GET['fileName'] ?? $argv[1];
$counter = new WordsCounter($file);
$counter->countWords();
echo "Самое частое слово: ";
print_r($counter->getTopOne());
echo "5 наиболее популярных слов: ";
print_r($counter->getTopFive());
echo "Все слова";
print_r($counter->getWords());

print "Memory usage " . memory_get_peak_usage() / 1024 / 1024 . " MB \n";
