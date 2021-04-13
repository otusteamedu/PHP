<?php


namespace App\Utils;


class HtmlCreator
{
    private string $template;

    /**
     * HtmlCreator constructor.
     * @param string|null $template
     */
    public function __construct(string $template = null)
    {
        $this->template = $template ?? $this->getDefaultTemplate();
    }

    /**
     * Create html file
     * @param $title
     * @param $body
     * @param string $description
     * @param string $keywords
     * @return string
     */
    public function createHtml($title, $body, $description = '', $keywords = ''): string
    {
        return sprintf($this->template, $title, $description, $keywords, $body);
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
    public function setTemplate(string $template): string
    {
        $this->template = $template;
    }


    /**
     * @return string
     */
    private function getDefaultTemplate(): string
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
