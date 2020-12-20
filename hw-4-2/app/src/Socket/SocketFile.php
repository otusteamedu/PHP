<?php

namespace Socket;

/**
 * Class SocketFile
 *
 * @package Socket
 */
class SocketFile
{
    /**
     * @var string
     */
    private string $fileName;

    /**
     * SocketFile constructor.
     *
     * @param $fileName
     */
    public function __construct ($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileName (): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getFilePath (): string
    {
        return '../' . $this->fileName;
    }

    /**
     * Удалить файл, если существует
     */
    public function unlink ()
    {
        if (file_exists($this->getFilePath())) {
            unlink($this->getFilePath());
        }
    }
}