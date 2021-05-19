<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Query;

class SelectQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string[]
     */
    private array $fields;

    /**
     * @var string
     */
    private string $from;

    /**
     * @var string[]
     */
    private array $where;

    /**
     * @var string[]
     */
    private array $between;

    /**
     * @var string
     */
    private string $limit;

    /**
     * @param string ...$select
     *
     * @return $this
     */
    public function select(string ...$select): static
    {
        $this->fields = $select;

        return $this;
    }

    /**
     * @param string $from
     *
     * @return $this
     */
    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string ...$where
     *
     * @return $this
     */
    public function where(string ...$where): static
    {
        foreach ($where as $arg) {
            $this->where[] = $arg;
        }

        return $this;
    }

    /**
     * @param string ...$statements
     *
     * @return $this
     */
    public function between(string ...$statements): static
    {
        foreach ($statements as $arg) {
            $this->between[] = $arg;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function limit(): static
    {
        $this->limit = 'LIMIT :limit';

        return $this;
    }

    /**
     * @return string
     */
    public function createQuery(): string
    {
        $where = empty($this->where) ? '' : 'AND ' . implode(' AND ', $this->where);
        $between = empty($this->between) ? '' : 'AND ' . implode(' AND ', $this->between);
        $fields = implode(', ', $this->fields);

        return "SELECT {$fields} FROM {$this->from} WHERE 1 {$where} {$between} {$this->limit};";
    }
}
