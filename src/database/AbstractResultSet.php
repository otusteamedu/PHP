<?php

namespace crazydope\theater\database;

use crazydope\theater\database\adapter\ResultInterface;
use Iterator;
use Countable;

abstract class AbstractResultSet implements ResultSetInterface, Iterator
{
    /**
     *  data source is already buffered
     */
    protected const DATA_SOURCE_BUFFERED = -1;
    /**
     * implicitly disabling buffering in ResultSet
     */
    protected const IMPLICITLY_DISABLE_BUFFERING = -2;
    /**
     * explicitly disabled
     */
    protected const EXPLICITLY_DISABLE_BUFFERING = false;
    /**
     * default state - nothing, but can buffer until iteration started
     */
    protected const BUFFER_DEFAULT_STATE = null;

    /**
     * if -1, data source is already buffered
     * if -2, implicitly disabling buffering in ResultSet
     * if false, explicitly disabled
     * if null, default state - nothing, but can buffer until iteration started
     * if array, already buffering
     * @var mixed
     */
    protected $buffer;

    /**
     * @var null|int
     */
    protected $count;

    /**
     * @var Iterator|\IteratorAggregate|ResultInterface
     */
    protected $dataSource;

    /**
     * @var int
     */
    protected $fieldCount;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @param $dataSource
     * @return AbstractResultSet
     */
    public function initialize($dataSource): self
    {
        // reset buffering
        if (is_array($this->buffer)) {
            $this->buffer = [];
        }

        if ($dataSource instanceof ResultInterface) {
            $this->fieldCount = $dataSource->getFieldCount();
            $this->dataSource = $dataSource;

            if ($dataSource->isBuffered()) {
                $this->buffer = self::DATA_SOURCE_BUFFERED;
            }

            if (is_array($this->buffer)) {
                $this->dataSource->rewind();
            }

            return $this;
        }

        if (is_array($dataSource)) {
            $firstElement = current($dataSource);
            reset($dataSource);
            $this->fieldCount = $firstElement === false ? 0 : count($firstElement);
            $this->dataSource = new \ArrayIterator($dataSource);
            $this->buffer = self::DATA_SOURCE_BUFFERED;
        } elseif ($dataSource instanceof \IteratorAggregate) {
            $this->dataSource = $dataSource->getIterator();
        } elseif ($dataSource instanceof \Iterator) {
            $this->dataSource = $dataSource;
        } else {
            throw new \InvalidArgumentException(
                'DataSource provided is not an array, nor does it implement Iterator or IteratorAggregate'
            );
        }

        return $this;
    }

    public function buffer(): self
    {
        if ($this->buffer === self::IMPLICITLY_DISABLE_BUFFERING) {
            throw new \RuntimeException('Buffering must be enabled before iteration is started');
        }

        if ($this->buffer === self::BUFFER_DEFAULT_STATE) {
            $this->buffer = [];
            if ($this->dataSource instanceof ResultInterface) {
                $this->dataSource->rewind();
            }
        }

        return $this;
    }

    public function isBuffered(): bool
    {
        return ($this->buffer === self::DATA_SOURCE_BUFFERED || is_array($this->buffer));
    }

    /**
     * @return Iterator|null
     */
    public function getDataSource(): ?\Iterator
    {
        return $this->dataSource;
    }

    /**
     * @return int
     */
    public function getFieldCount(): int
    {
        if (null !== $this->fieldCount) {
            return $this->fieldCount;
        }

        $dataSource = $this->getDataSource();
        if (null === $dataSource) {
            return 0;
        }

        $dataSource->rewind();
        if (!$dataSource->valid()) {
            $this->fieldCount = 0;
            return 0;
        }

        $row = $dataSource->current();
        if (is_object($row) && $row instanceof Countable) {
            $this->fieldCount = $row->count();
            return $this->fieldCount;
        }

        $row = (array)$row;
        $this->fieldCount = count($row);
        return $this->fieldCount;
    }

    public function next(): void
    {
        if ($this->buffer === self::BUFFER_DEFAULT_STATE) {
            $this->buffer = self::IMPLICITLY_DISABLE_BUFFERING;
        }

        if (!is_array($this->buffer) || $this->position === $this->dataSource->key()) {
            $this->dataSource->next();
        }

        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function current()
    {
        if ($this->buffer === self::DATA_SOURCE_BUFFERED) {
            return $this->dataSource->current();
        }

        if ($this->buffer === self::BUFFER_DEFAULT_STATE) {
            $this->buffer = self::IMPLICITLY_DISABLE_BUFFERING;
        } elseif (is_array($this->buffer) && isset($this->buffer[$this->position])) {
            return $this->buffer[$this->position];
        }

        $data = $this->dataSource->current();
        if (is_array($this->buffer)) {
            $this->buffer[$this->position] = $data;
        }

        return is_array($data) ? $data : null;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        if (is_array($this->buffer) && isset($this->buffer[$this->position])) {
            return true;
        }
        if ($this->dataSource instanceof \Iterator) {
            return $this->dataSource->valid();
        } else {
            $key = key($this->dataSource);
            return ($key !== null);
        }
    }

    public function rewind(): void
    {
        if (!is_array($this->buffer)) {
            if ($this->dataSource instanceof Iterator) {
                $this->dataSource->rewind();
            } else {
                reset($this->dataSource);
            }
        }
        $this->position = 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        if ($this->dataSource instanceof Countable) {
            $this->count = count($this->dataSource);
        }

        if ($this->count !== null) {
            return $this->count;
        }

        return $this->count;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $return = [];
        foreach ($this as $row) {
            if (is_array($row)) {
                $return[] = $row;
            } elseif (method_exists($row, 'toArray')) {
                $return[] = $row->toArray();
            } elseif (method_exists($row, 'getArrayCopy')) {
                $return[] = $row->getArrayCopy();
            } else {
                throw new \RuntimeException(
                    'Rows as part of this DataSource, with type ' . gettype($row) . ' cannot be cast to an array'
                );
            }
        }
        return $return;
    }
}