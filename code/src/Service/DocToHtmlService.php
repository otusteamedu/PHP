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
    const TITLE_POSTFIX = ' в Москве - Автосервис "Ровер"';
    const DESCRIPTION_POSTFIX = ' в Москве. Бесплатная диагностика. Гарантия качества. Записаться - 8(XXX)XXX-XX-XX.';

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
                $this->getTitle($title),
                $body,
                $this->getDescription($title)
            );

            $this->storage->save(
                $this->getFilename($title),
                $html
            );
            $counter++;
        }

        return $counter;
    }

    private function getTitle(string $title): string
    {
        return $title . self::TITLE_POSTFIX;
    }

    private function getDescription(string $title): string
    {
        return $title . self::DESCRIPTION_POSTFIX;
    }

    private function getFilename(string $title): string
    {
        return $title . '.html';
    }


}
