<?php

namespace Sergey\Otus\View;

abstract class Html
{
    /**
     * @var array
     */
    protected $headElements = [];

    /**
     * @param string $message
     * @return mixed
     */
    abstract protected function htmlBody($message);

    /**
     * @param $message
     * @return void
     */
    abstract protected function init($message);

    /**
     * @param string $message
     */
    public function display($message)
    {
        $this->init($message);
        echo $this->htmlHeader();
        echo $this->htmlBody($message);
        echo $this->htmlFooter();
    }

    /**
     * @return string
     */
    protected function htmlHeader()
    {
        return "<html><head>" . $this->htmlHead() . "</head><body>";
    }

    /**
     * @return string
     */
    protected function htmlFooter()
    {
        return "</body></html>";
    }

    /**
     * @return string
     */
    protected function htmlHead()
    {
        return implode($this->headElements);
    }
}