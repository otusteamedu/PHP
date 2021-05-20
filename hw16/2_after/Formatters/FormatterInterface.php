<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Formatters;

interface FormatterInterface
{
    /**
     * @param array $orders
     * @param string $viewsPath
     *
     * @return mixed
     */
    public function format(array $orders, string $viewsPath): mixed;
}
