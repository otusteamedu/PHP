<?php

namespace crazydope\theater\database\adapter;

class PdoAdapter implements PdoAdapterInterface
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var bool|\PDOStatement
     */
    protected $lastStatement;

    /**
     * @param $value
     * @return array
     */
    public static function toArray($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null) {
            return [];
        }

        if (!$value instanceof \Traversable) {
            throw new \InvalidArgumentException(
                'Invalid value was provided, should be null, array or Traversable'
            );
        }

        return iterator_to_array($value);
    }

    /**
     * PDO constructor.
     * @param string $dsn
     * @param null $username
     * @param null $passwd
     */
    public function __construct(string $dsn, $username = null, $passwd = null)
    {
        $this->connection = new \PDO($dsn, $username, $passwd);
    }

    /**
     * @param $statement
     * @param null $options
     * @return bool|\PDOStatement
     */
    public function prepare($statement, $options = null)
    {
        $options = self::toArray($options);
        $this->lastStatement = $this->connection->prepare($statement, $options);

        return $this->lastStatement;
    }

    /**
     * @return bool
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @return bool
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * @return bool
     */
    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    /**
     * @return bool
     */
    public function inTransaction(): bool
    {
        return $this->connection->inTransaction();
    }

    /**
     * @param $statement
     * @return bool|int
     */
    public function exec($statement)
    {
        $statement = $this->prepare($statement);
        $result = $statement->execute();

        return $result === false ? false : $statement->rowCount();
    }

    /**
     * @param $statement
     * @return bool|\PDOStatement
     */
    public function query($statement)
    {
        $statement = $this->prepare($statement);
        $result = $statement->execute();
        return $result === false ? false : $statement;
    }

    /**
     * @param $name
     * @return string
     */
    public function lastInsertId($name = null)
    {
        return $this->connection->lastInsertId($name);
    }

    /**
     * @return bool|string
     */
    public function errorCode()
    {
        if ($this->lastStatement instanceof \PDOStatement) {
            return $this->lastStatement->errorCode();
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function errorInfo()
    {
        if ($this->lastStatement instanceof \PDOStatement) {
            return $this->lastStatement->errorInfo();
        }

        return false;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function setAttribute($attribute, $value): bool
    {
        return $this->connection->setAttribute($attribute, $value);
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->connection->getAttribute($attribute);
    }

    /**
     * @return bool|\PDOStatement
     */
    public function getLastStatement()
    {
        return $this->lastStatement;
    }
}