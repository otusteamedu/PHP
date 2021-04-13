<?php
declare(strict_types=1);


namespace App\Console;


use App\Repository\DocFilesRepository;
use App\Service\DocToHtmlService;
use App\Utils\Storage\FileStorage;

class App
{
    const DOCS_PATH = __DIR__ . '/../../../docs';
    const HTML_PATH = __DIR__ . '/../../../output';

    private DocToHtmlService $docToHtmlService;

    /**
     * App constructor.
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function __construct()
    {
        $this->docToHtmlService = new DocToHtmlService(
            new DocFilesRepository(    self::DOCS_PATH),
            new FileStorage(     self::HTML_PATH)
        );
    }


    /**
     * @throws \App\Utils\Exception\FileNotSaveException
     * @throws \Exception
     */
    public function run(): void
    {
        $counter = $this->docToHtmlService->process();

        echo sprintf('Записано %d файлов', $counter), PHP_EOL;
    }

}
