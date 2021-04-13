<?php




use InvalidArgumentException;

class HtmlCreator
{
    private $template;
    private $outputFile;

    /**
     * HtmlCreator constructor.
     * @param string|null $template
     */
    public function __construct(string $template = null)
    {
        $this->template = $template ?? $this->setDefaultTemplate();
    }

    /**
     * Create html file
     * @param $title
     * @param $body
     * @param string $description
     * @param string $keywords
     * @return false|int
     */
    public function createHtml($title, $body, $description = '', $keywords = '')
    {
        if (null === $this->outputFile) {
            throw new InvalidArgumentException('Output filename must be set.');
        }

        $html = sprintf($this->template, $title, $description, $keywords, $body);

        return file_put_contents($this->outputFile, $html);
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }

    /**
     * @param string $outputFile
     */
    public function setOutputFile(string $outputFile)
    {
        $this->outputFile = $outputFile;
    }


    /**
     * @return string
     */
    private function setDefaultTemplate()
    {
        return <<<EOF
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>%s</title>
	<meta name="description" content="%s">
	<meta name="keywords" content="%s" />
</head>
<body>
%s
</body>
</html>
EOF;
    }

}
