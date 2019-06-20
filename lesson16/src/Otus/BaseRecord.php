<?php

namespace Otus;

use Exception;

/**
 * Class BaseRecord
 * @package Otus
 */
abstract class BaseRecord
{
    /**
     * Model attributes
     * @var array
     */
    protected $attributes;

    /**
     * DB name
     * @var null
     */
    public static $database = null;

    /**
     * MongoDB Client
     * @var null
     */
    public static $connection = null;

    /**
     * Collection name
     * @var null
     */
    protected static $collectionName = null;

    /**
     * BaseRecord constructor.
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        if (isset($attributes['id']) AND !isset($attributes['_id'])) {
            $attributes['_id'] = $attributes['id'];
            unset($attributes['id']);
        }
        $this->attributes = $attributes;
    }

    /**
     * Save document in Mongo
     * @param array $options
     * @return bool
     * @throws Exception
     */
    public function save(array $options = array())
    {
        $collection = self::getCollection();
        if (isset($this->attributes['_id'])) {
            if (!array_key_exists('upsert', $options)) {
                $options['upsert'] = true;
            }
            $fields = static::$fields;
            foreach ($this->attributes as $attributeName => $attribute) {
                if (!in_array($attributeName, $fields) && $attributeName != '_id') {
                    unset($this->attributes[$attributeName]);
                }
            }
            $collection->findOneAndUpdate(['_id' => $this->attributes['_id']], ['$set' => $this->attributes], $options);
            return true;
        }
        $collection->insertOne($this->attributes, $options);
        return true;
    }

    /**
     * Delete document from Mongo
     * @return bool
     * @throws Exception
     */
    public function delete()
    {
        $collection = self::getCollection();
        $collection->deleteOne(array('_id' => $this->attributes['_id']));
        $this->attributes = [];
        return true;
    }

    /**
     * Find Documents in Mongo
     * @param array $query
     * @param array $options
     * @return array
     * @throws Exception
     */
    public static function find($query = array(), $options = array())
    {
        $collection = self::getCollection();
        $cursor = $collection->find($query, $options);
        $documents = [];
        foreach ($cursor as $document) {
            $documents[] = self::instantiate((array)$document);
        }
        return $documents;
    }


    /**
     * Aggregate Query
     * @param array $pipeline
     * @param array $options
     * @return array
     * @throws Exception
     */
    public static function aggregate($pipeline = array(), $options = array())
    {
        $collection = self::getCollection();
        $cursor = $collection->aggregate($pipeline, $options);
        $documents = [];
        foreach ($cursor as $document) {
            $documents[] = self::instantiate((array)$document);
        }
        return $documents;
    }

    /**
     * Find one document
     * @param array $query
     * @param array $options
     * @return null
     * @throws Exception
     */
    public static function findOne($query = array(), $options = array())
    {
        $collection = self::getCollection();
        $record = $collection->findOne($query, $options);
        return self::instantiate((array)$record);
    }

    /**
     * Find document by id
     * @param $id
     * @param array $options
     * @return null
     * @throws Exception
     */
    public static function findOneById($id, $options = array())
    {
        $collection = self::getCollection();
        $record = $collection->findOne(['_id' => $id], $options);
        return self::instantiate((array)$record);
    }

    /**
     * Count documents query
     * @param array $query
     * @return mixed
     * @throws Exception
     */
    public static function count($query = array())
    {
        $collection = self::getCollection();
        $documents = $collection->count($query);
        return $documents;
    }

    /**
     * Instantiate document to model
     * @param $document
     * @return null
     */
    private static function instantiate($document)
    {
        if ($document) {
            $className = get_called_class();
            return new $className($document, false);
        } else {
            return null;
        }
    }

    /**
     * Get id from document
     * @return mixed
     */
    public function getID()
    {
        return $this->attributes['_id'];
    }

    /**
     * Set id to document
     * @param $id
     * @return $this
     */
    public function setID($id)
    {
        $this->attributes['_id'] = $id;
        return $this;
    }

    /**
     * Auto getters and setters for attributes
     * @param $method
     * @param $arguments
     * @return $this|mixed|void|null
     * @throws Exception
     */
    public function __call($method, $arguments)
    {
        // Is this a get or a set
        $prefix = strtolower(substr($method, 0, 3));
        if ($prefix != 'get' && $prefix != 'set')
            return;
        // What is the get/set class attribute
        $property = lcfirst(substr($method, 3));
        if (empty($prefix) || empty($property)) {
            // Did not match a get/set call
            throw New Exception("Calling a non get/set method that does not exist: $method");
        }
        // Get
        if ($prefix == "get" && array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        } else if ($prefix == "get") {
            return null;
        }
        // Set
        if ($prefix == "set" && array_key_exists(0, $arguments)) {
            $this->attributes[$property] = $arguments[0];
            return $this;
        } else {
            throw new Exception("Calling a get/set method that does not exist: $property");
        }
    }

    /**
     * Get collection
     * @return mixed
     * @throws Exception
     */
    protected static function getCollection()
    {
        $className = get_called_class();
        if (null !== static::$collectionName) {
            $collectionName = static::$collectionName;
        } else {
            throw new Exception('No collection name');
        }
        if ($className::$database == null)
            throw new Exception("BaseRecord::database must be initialized to a proper database string");
        if ($className::$connection == null)
            throw new Exception("BaseRecord::connection must be initialized to a valid Mongo object");
        if (!($className::$connection->connected))
            $className::$connection->connect();
        return $className::$connection->selectCollection($className::$database, $collectionName);
    }

    /**
     * Get attributes
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

}
