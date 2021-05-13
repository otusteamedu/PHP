<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Generator;
use SplObjectStorage;

abstract class RelationalModel extends BaseModel
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * RelationalModel constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return bool
     */
    abstract public function insert(): bool;

    /**
     * @return bool
     */
    abstract public function update(): bool;

    /**
     * @return bool
     */
    abstract public function delete(): bool;

    /**
     * @param PDO $pdo
     *
     * @return SplObjectStorage
     */
    abstract public static function all(PDO $pdo): SplObjectStorage;

    /**
     * Return generator that yield one model at a time.
     * Useful if table is huge.
     *
     * @param PDO $pdo
     *
     * @return Generator
     */
    abstract public static function cursor(PDO $pdo): Generator;

    /**
     * @param PDO $pdo
     * @param int $id
     *
     * @return static
     */
    abstract public static function find(PDO $pdo, int $id): static;
}
