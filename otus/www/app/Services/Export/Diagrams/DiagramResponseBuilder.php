<?php


namespace App\Services\Export\Diagrams;


class DiagramResponseBuilder
{
    private $filePath;
    private $height;
    private $width;

    private $errors;

    public function setFilePath($filePath)
    {
        $this->filePath = (string)$filePath;
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = (int)$height;
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = (int)$width;
        return $this;
    }

    public function build()
    {
        $this->validate();

        if (!empty($this->error)) {
            throw new \RuntimeException(implode(';', $this->error));
        }
        return DiagramResponse::build($this);
    }

    public function validate()
    {
        if (empty($this->filePath)) {
            $this->errors[] = 'Не задан путь к файлу';
        }

        if (empty($this->height)) {
            $this->errors[] = 'Не задана высота файла';
        }

        if (empty($this->width)) {
            $this->errors[] = 'Не задана ширина файла';
        }

    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }
}
