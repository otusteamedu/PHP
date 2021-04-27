<?php

namespace App\ModelHydrators;

use stdClass;

interface YoutubeHydratorInterface
{
    /**
     * @param stdClass $modelRawData
     *
     * @return array
     */
    public function hydrate(stdClass $modelRawData): array;
}
