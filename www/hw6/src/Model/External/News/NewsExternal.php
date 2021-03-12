<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\External\News;

class NewsExternal
{
    private string $text = "";

    public function addText(string $text)
    {
        $this->text .= $text;
    }

    public function clear()
    {
        $this->text = "";
    }

    public function save(string $file_name)
    {
        return "Saving to $file_name text: " . $this->text;
    }
}
