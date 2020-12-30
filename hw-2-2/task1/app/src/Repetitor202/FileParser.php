<?php


namespace Repetitor202;


class FileParser
{
    private $contents;

    /**
     * @param string $fileName
     */
    private final function setContents(string $fileName): void
    {
        $this->contents = file_get_contents($fileName, true);
    }

    /**
     * @param string $fileName
     *
     * @return array
     */
    public final function getLines(string $fileName): array
    {
        $this->setContents($fileName);

        return explode("\n", $this->contents);
    }
}