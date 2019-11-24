<?php

namespace Core;

use stdClass;

class AppNode
{
    private $page = "";
    private $controllerName = "";
    private $methodName = "";
    private $exists = false;

    /**
     * AppNode constructor.
     * @param stdClass|null $row
     */
    public function __construct(?stdClass $row = null)
    {
        if ($row instanceof stdClass) {
            $this->build($row);
        }
    }

    public function isPage(): bool
    {
        return !empty($this->page);
    }

    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @return string|null
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string|null
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }

    /**
     * @param stdClass $row
     */
    private function build(stdClass $row)
    {
        $this->page = $row->page ?? "";
        $this->controllerName = $row->controller ?? "";
        if ($row->controller ?? null) {
            $this->methodName = $row->method ?? "";
        }
        $this->exists = !empty($row->page) || (!empty($row->controller) && !empty($row->method));
    }
}