<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Formatters;

class OrderBriefFormatter implements FormatterInterface
{
    const VIEWS_PATH = '/views';

    /**
     * @param array $orders
     * @param string $viewsPath
     *
     * @return void
     */
    public function format(array $orders, string $viewsPath): void
    {
        $basePath = self::VIEWS_PATH;
        require_once "{$basePath}/{$viewsPath}";
    }
}
