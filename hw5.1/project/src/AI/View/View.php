<?php

namespace AI\backend_php_hw5_1\View;


use AI\backend_php_hw5_1\Exceptions\FileException;

class View
{
    /**
     * @var string
     */
    private string $viewsDir;

    /**
     * View constructor.
     *
     * @param string $viewsDir
     *
     * @throws FileException
     */
    public function __construct(string $viewsDir)
    {
        if (!is_dir($viewsDir)) {
            throw new FileException("Каталога '{$viewsDir}' не существует");
        }

        $this->viewsDir = $viewsDir;
    }

    /**
     * @param string $templateName
     * @param array $data
     *
     * @throws FileException
     */
    public function out(string $templateName, array $data): void
    {
        $templateContent = $this->getTemplateContent($templateName);
        echo $this->render($templateContent, $data);
    }

    /**
     * @param string $templateName
     *
     * @return string
     *
     * @throws FileException
     */
    private function getTemplateContent(string $templateName): string
    {
        $templateFilename = $this->resolveTemplateFilename($templateName);
        $content = file_get_contents($templateFilename);

        if ($content === false) {
            $error = error_get_last();
            throw new FileException("Ошибка чтения шаблона: {$error['message']}");
        }

        return $content;
    }

    /**
     * @param string $template
     *
     * @return string
     *
     * @throws FileException
     */
    private function resolveTemplateFilename(string $template): string
    {
        $prefix = PHP_SAPI == 'cli' ? 'cli.' : 'web.';
        $filename = $this->viewsDir . $prefix . $template . '.php';

        if (!file_exists($filename)) {
            throw new FileException("Файла '{$filename}' не существует");
        }

        return $filename;
    }

    /**
     * @param string $templateContent
     * @param array $data
     *
     * @return string
     */
    private function render(string $templateContent, array $data): string
    {
        $variables = array_keys($data);
        $variables = array_map(function ($val) {
                return '{{ ' . $val . ' }}';
            }, $variables);

        $values = array_values($data);

        return str_replace($variables, $values, $templateContent);
    }
}
