<?php
declare(strict_types=1);


namespace App\Service;


use App\Repository\RepositoryInterface;
use App\Utils\DocParser;
use App\Utils\HtmlCreator;
use App\Utils\Storage\StorageInterface;
use PhpOffice\PhpWord\IOFactory;

class DocToHtmlService
{
    private RepositoryInterface $docRepository;
    private StorageInterface $storage;
    private DocParser $docParser;
    private HtmlCreator $htmlCreator;

    /**
     * DocToHtmlService constructor.
     * @param \App\Repository\RepositoryInterface $docRepository
     * @param \App\Utils\Storage\StorageInterface $storage
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function __construct(RepositoryInterface $docRepository, StorageInterface $storage)
    {
        $this->docRepository = $docRepository;
        $this->storage = $storage;
        $this->docParser = new DocParser(IOFactory::createReader());
        $this->htmlCreator = new HtmlCreator();
    }

    /**
     * @throws \Exception
     */
    public function process(): int
    {
        $files = $this->docRepository->findAll();
        $counter = 0;
        foreach ($files as $file) {
            list($title, $body) = $this->docParser->parseFile($file);
            $html = $this->htmlCreator->createHtml(
                $title . ' в Москве - Автосервис "Ровер"',
                $body,
                $title . ' в Москве. Бесплатная диагностика. Гарантия качества. Записаться - 8(495)150-70-69.'
            );

            $this->storage->save($title . '.html', $html);
            $counter++;
        }

        return $counter;
    }


}
