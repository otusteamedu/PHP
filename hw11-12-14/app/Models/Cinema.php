<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Closure;
use Generator;
use PDOStatement;
use SplObjectStorage;
use JetBrains\PhpStorm\Pure;
use JetBrains\PhpStorm\ArrayShape;

class Cinema extends RelationalModel
{
    /**
     * @var PDOStatement|false
     */
    private PDOStatement|false $insertStatement;

    /**
     * @var PDOStatement|false
     */
    private PDOStatement|false $updateStatement;

    /**
     * @var PDOStatement|false
     */
    private PDOStatement|false $deleteStatement;

    /**
     * @var ?int
     */
    private ?int $id;

    /**
     * @var ?string
     */
    private ?string $title;

    /**
     * @var Closure|null
     */
    private ?Closure $hallsReference;

    /**
     * @var SplObjectStorage|null
     */
    private ?SplObjectStorage $halls;

    /**
     * Cinema constructor.
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->setHallsReference();
        $this->insertStatement = $this->pdo->prepare('INSERT INTO cinemas (title) VALUES (?);');
        $this->updateStatement = $this->pdo->prepare('UPDATE cinemas SET title = ? where id = ?;');
        $this->deleteStatement = $this->pdo->prepare('DELETE from cinemas where id = ?;');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param ?string $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return SplObjectStorage
     */
    public function getHalls(): SplObjectStorage
    {
        if (!isset($this->halls)) {
            $reference = $this->hallsReference;
            $this->halls = $reference($this->pdo, $this->getId());
        }

        return $this->halls;
    }

    /**
     * @return void
     */
    private function setHallsReference(): void
    {
        $relationalReference = function ($pdo, $modelId) {
            if ($modelId) {

                return Hall::findBy($pdo, 'cinema_id', $modelId);
            }

            return null;
        };

        $this->hallsReference = $relationalReference;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStatement->execute([
            $this->title
        ]);
        $this->id = (int)$this->pdo->lastInsertId();

        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->title,
            $this->id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;

        return $this->deleteStatement->execute([$id]);
    }

    /**
     * @return array
     */
    #[Pure]
    #[ArrayShape(['id' => "int", 'title' => "string"])]
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle()
        ];
    }

    /**
     * @param PDO $pdo
     * @param int $id
     *
     * @return static
     */
    public static function find(PDO $pdo, int $id): static
    {
        $selectStatement = $pdo->prepare('SELECT id, title from cinemas where id = ?;');
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute([$id]);
        $result = $selectStatement->fetch();

        return (new self($pdo))
            ->setId($result['id'])
            ->setTitle($result['title']);
    }

    /**
     * @param PDO $pdo
     *
     * @return SplObjectStorage
     */
    public static function all(PDO $pdo): SplObjectStorage
    {
        $selectStatement = $pdo->prepare('SELECT id, title from cinemas;');
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute();

        $collection = new SplObjectStorage();
        while ($result = $selectStatement->fetch()) {
            $model = (new self($pdo))
                ->setId($result['id'])
                ->setTitle($result['title']);

            $collection->attach($model);
        }

        return $collection;
    }

    /**
     * Return generator that yield one model at a time.
     * Useful if table is huge.
     *
     * @param PDO $pdo
     *
     * @return Generator
     */
    public static function cursor(PDO $pdo): Generator
    {
        $selectStatement = $pdo->prepare('SELECT id, title from cinemas;');
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute();

        while ($result = $selectStatement->fetch()) {
            yield (new self($pdo))
                ->setId($result['id'])
                ->setTitle($result['title']);
        }
    }
}
