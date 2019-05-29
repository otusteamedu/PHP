<?php

namespace crazydope\theater\database\adapter;

use PDO;
use PDOStatement;

class Result implements ResultInterface
{
    public const STATEMENT_MODE_SCROLLABLE = 'scrollable';
    public const STATEMENT_MODE_FORWARD = 'forward';

    /**
     *
     * @var string
     */
    protected $statementMode = self::STATEMENT_MODE_FORWARD;

    /**
     * @var int
     */
    protected $fetchMode = PDO::FETCH_ASSOC;

    /**
     * @var PDOStatement
     */
    protected $resource;

    /**
     * @var array Result options
     */
    protected $options;

    /**
     * Is the current complete?
     * @var bool
     */
    protected $currentComplete = false;

    /**
     * Track current item in recordset
     * @var mixed
     */
    protected $currentData;

    /**
     * @var int
     */
    protected $position = -1;

    /**
     * @var null
     */
    protected $rowCount;

    /**
     * @param PDOStatement $resource
     * @param int $rowCount
     * @return self Provides a fluent interface
     */
    public function initialize(PDOStatement $resource, $rowCount = null): self
    {
        $this->resource = $resource;
        $this->rowCount = $rowCount;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isBuffered(): ?bool
    {
        return false;
    }

    /**
     * @param int $fetchMode
     * @throws \InvalidArgumentException on invalid fetch mode
     */
    public function setFetchMode($fetchMode): void
    {
        if ($fetchMode < 1 || $fetchMode > 10) {
            throw new \InvalidArgumentException(
                'The fetch mode must be one of the PDO::FETCH_* constants.'
            );
        }

        $this->fetchMode = (int)$fetchMode;
    }

    /**
     * @return int
     */
    public function getFetchMode(): int
    {
        return $this->fetchMode;
    }

    /**
     * @return PDOStatement
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function current(): array
    {
        if ($this->currentComplete) {
            return $this->currentData;
        }

        $this->currentData = $this->resource->fetch($this->fetchMode);
        $this->currentComplete = true;
        return $this->currentData;
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        $this->currentData = $this->resource->fetch($this->fetchMode);
        $this->currentComplete = true;
        $this->position++;
        return $this->currentData;
    }

    /**
     * @return int|mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return void
     * @throws \RuntimeException
     */
    public function rewind(): void
    {
        if ($this->statementMode === self::STATEMENT_MODE_FORWARD && $this->position > 0) {
            throw new \RuntimeException(
                'This result is a forward only result set, calling rewind() after moving forward is not supported'
            );
        }
        $this->currentData = $this->resource->fetch($this->fetchMode);
        $this->currentComplete = true;
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->currentData !== false);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        if (is_int($this->rowCount)) {
            return $this->rowCount;
        }

        $this->rowCount = (int)$this->resource->rowCount();

        return $this->rowCount;
    }

    /**
     * @return int
     */
    public function getFieldCount(): int
    {
        return $this->resource->columnCount();
    }

    /**
     * @return bool
     */
    public function isQueryResult(): bool
    {
        return ($this->resource->columnCount() > 0);
    }

    /**
     * @return int
     */
    public function getAffectedRows(): int
    {
        return $this->resource->rowCount();
    }
}