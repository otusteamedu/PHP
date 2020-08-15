<?php

namespace Sources;

interface MethodsInterface {
    public function getTop();

    public function getAll();

    public function getPage(int $page);
}
