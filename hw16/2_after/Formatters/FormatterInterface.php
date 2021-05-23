<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Formatters;

interface FormatterInterface
{
    /**
     * @param array $orders
     * @param string $viewsPath
     *
     * @return void
     */
    public function format(array $orders, string $viewsPath): void;
}
