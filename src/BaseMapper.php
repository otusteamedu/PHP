<?php

namespace Bjlag;

use Bjlag\Db\Store;

abstract class BaseMapper
{
    protected const LINK_FIELD = 'link_field';
    protected const LINK_SETTER = 'setter';

    /** @var \Bjlag\Db\Store */
    protected $db;

    abstract public function findById(string $id);

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
