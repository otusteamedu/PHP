<?php
declare(strict_types=1);
/*
 * Имена стилей должны быть заданы в .docx файле
 * допускается любое имя и соответствие тегу.
 * Установить свои стили setTags(['style1' => 'tag1', 'style2' => 'tag2',...])
 * или в конструкторе.
 */

namespace App\Utils;

use InvalidArgumentException;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Reader\ReaderInterface;


class DocParser
{
    const TAGS = [
        'H1' => 'h1',
        'H2' => 'h2',
        'H3' => 'h3',
        'ListParagraph' => 'li',
        'Normal' => 'p',
    ];

    private ReaderInterface $reader;
    private array $tags;


    /**
     * DocParser constructor.
     * @param \PhpOffice\PhpWord\Reader\ReaderInterface $reader
     * @param null|array $tags
     */
    public function __construct(ReaderInterface $reader, $tags = null)
    {
        $this->reader = $reader;

        if (null !== $tags) {
            $this->setTags($tags);
        } else {
            $this->tags = self::TAGS;
        }
    }


    /**
     * Парсинг .docx файла
     * @param string $filename
     * @param false $minimize , если true файл тело будет в одну строку
     * @return string[]
     * @throws \Exception
     */
    public function parseFile(string $filename, bool $minimize = false): array
    {
        $phpWord = $this->reader->load($filename);
        $body = '';
        $title = '';
        $tab = $minimize ? '' : "\t";
        $newLine = $minimize ? '' : "\n";

        foreach ($phpWord->getSections() as $section) {
            $sectionElement = $section->getElements();

            // set if tag == li
            $ulOpened = false;

            foreach ($sectionElement as $elementValue) {

                if ($elementValue instanceof TextRun) {
                    $styleName = $elementValue->getParagraphStyle()->getStyleName();

                    $tag = $this->tags[$styleName] ?? 'p';

                    if ($tag === 'li' && !$ulOpened) { // открыть ul
                        $body .= sprintf('%s<ul>%s', $tab, $newLine);
                        $ulOpened = true;
                    } else if ($tag !== 'li' && $ulOpened) { // закрыть ul tag if next tag not li
                        $body .= sprintf('%s</ul>%s', $tab, $newLine);
                        $ulOpened = false;
                    }
                    $body .= sprintf("%s<%s>", $tag === 'li' ? $tab . $tab : $tab, $tag);

                    // span для bold шрифтов
                    $spanOpened = false;

                    foreach ($elementValue->getElements() as $elementText) {
                        if ($elementText instanceof Text) {

                            if ($tag === 'h1') {
                                $title .= $elementText->getText();
                            }

                            // проверить шрифт на bold
                            $font = $elementText->getFontStyle();
                            if ($font->isBold() && !$spanOpened) {
                                $body .= '<span style="font-weight: bold;">';
                                $spanOpened = true;
                            } else if (!$font->isBold() && $spanOpened) {
                                $body .= '</span>';
                                $spanOpened = false;
                            }

                            $body .= $elementText->getText();

                        }
                    }
                    $body .= sprintf("</%s>%s", $tag, $newLine);
                }
            }
        }

        return [ $title, $body];
    }


    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        if (!$this->isAssoc($tags))
            throw new InvalidArgumentException('tags must be array.');
        $this->tags = $tags;
    }


    /**
     * @param array $arr
     * @return bool
     */
    private function isAssoc(array $arr): bool
    {
        if (!is_array($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }


}
