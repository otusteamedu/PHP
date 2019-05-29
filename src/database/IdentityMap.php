<?php

namespace crazydope\theater\database;

class IdentityMap implements IdentityMapInterface
{
    /**
     * @var \ArrayObject
     */
    protected $idToObject;

    /**
     * @var \SplObjectStorage
     */
    protected $objectToId;

    public function __construct()
    {
        $this->objectToId = new \SplObjectStorage();
        $this->idToObject = new \ArrayObject();
    }

    /**
     * @param integer $id
     * @param mixed $object
     */
    public function set(int $id, $object): void
    {
        $this->idToObject[$id] = $object;
        $this->objectToId[$object] = $id;
    }

    /**
     * @param mixed $object
     * @return integer
     * @throws \OutOfBoundsException
     */
    public function getId($object): int
    {
        if ($this->hasObject($object) === false) {
            throw new \OutOfBoundsException();
        }

        return $this->objectToId[$object];
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function hasId(int $id): bool
    {
        return isset($this->idToObject[$id]);
    }

    /**
     * @param mixed $object
     * @return boolean
     */
    public function hasObject($object): bool
    {
        return isset($this->objectToId[$object]);
    }

    /**
     * @param integer $id
     * @return object
     * @throws \OutOfBoundsException
     */
    public function getObject(int $id)
    {
        if ($this->hasId($id) === false) {
            throw new \OutOfBoundsException();
        }

        return $this->idToObject[$id];
    }

    /**
     * @param int $id
     * @throws \OutOfBoundsException
     */
    public function deleteObject(int $id): void
    {
        if ($this->hasId($id) === false) {
            throw new \OutOfBoundsException();
        }

        $object = $this->getObject($id);
        $this->objectToId->offsetUnset($object);
        $this->idToObject->offsetUnset($id);
    }
}