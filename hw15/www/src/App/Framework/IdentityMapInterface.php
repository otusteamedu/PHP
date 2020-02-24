<?php


namespace App\Framework;

use OutOfBoundsException;

interface IdentityMapInterface
{
    /**
     * @param string $id
     * @param mixed $object
     */
    public function set($id, $object);
    /**
     * @param mixed $object
     * @throws OutOfBoundsException
     * @return string
     */
    public function getId($object);

    /**
     * @param string $id
     * @return boolean
     */
    public function hasId($id);

    /**
     * @param mixed $object
     * @return boolean
     */
    public function hasObject($object);

    /**
     * @param integer $id
     * @throws OutOfBoundsException
     * @return object
     */
    public function getObject($id);
}