<?php

namespace Bjlag;

use Bjlag\Db\Store;

abstract class BaseMapper
{
    /** @var \Bjlag\Db\Store */
    protected $db;

    /**
     * @param \Bjlag\Db\Store|null $db
     */
    public function __construct(Store $db = null)
    {
        if ($db === null) {
            $this->db = App::getDb();
        } else {
            $this->db = $db;
        }
    }
}
