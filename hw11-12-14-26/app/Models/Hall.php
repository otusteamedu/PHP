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

class Hall extends RelationalModel
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
     * @var ?int
     */
    private ?int $cinema_id;

    /**
     * @var ?int
     */
    private ?int $number;

    /**
     * @var ?string
     */
    private ?string $title;

    /**
     * @var Closure|null
     */
    private ?Closure $cinemaReference;

    /**
     * @var Cinema|null
     */
    private ?Cinema $cinema;

    /**
     * Hall constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->setCinemaReference();
        $this->insertStatement = $this->pdo->prepare('INSERT INTO halls (number, title) VALUES (?, ?)');
        $this->updateStatement = $this->pdo->prepare('UPDATE halls SET cinema_id = ?, number = ?, title = ? where id = ?');
        $this->deleteStatement = $this->pdo->prepare('DELETE from halls where id = ?');
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id ?? null;
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
     * @return int|null
     */
    public function getCinemaId(): ?int
    {
        return $this->cinema_id ?? null;
    }

    /**
     * @param int|null $cinemaId
     *
     * @return $this
     */
    public function setCinemaId(?int $cinemaId): self
    {
        $this->cinema_id = $cinemaId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     *
     * @return $this
     */
    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param ?string $title
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ?Cinema
     */
    public function getCinema(): ?Cinema
    {
        if (!isset($this->cinema)) {
            $reference = $this->cinemaReference;
            $this->cinema = $reference($this->pdo, $this->getCinemaId());
        }

        return $this->cinema;
    }

    /**
     * @return void
     */
    private function setCinemaReference(): void
    {
        $relationalReference = function ($pdo, $relationalModelId) {
            if ($relationalModelId) {

                return Cinema::find($pdo, $relationalModelId);
            }

            return null;
        };

        $this->cinemaReference = $relationalReference;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStatement->execute([
            $this->cinema_id,
            $this->number,
            $this->title,
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
            $this->cinema_id,
            $this->number,
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
    #[ArrayShape(['id' => "mixed", 'cinema_id' => "mixed", 'number' => "mixed", 'title' => "mixed"])]
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'cinema_id' => $this->getCinemaId(),
            'number' => $this->getNumber(),
            'title' => $this->getTitle(),
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
        $selectStatement = $pdo->prepare('SELECT id, cinema_id, number, title from halls where id = ?;');
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute([$id]);
        $result = $selectStatement->fetch();

        return (new self($pdo))
            ->setId($result['id'])
            ->setCinemaId($result['cinema_id'])
            ->setNumber($result['number'])
            ->setTitle($result['title']);
    }

    /**
     * @param PDO $pdo
     * @param string $column
     * @param int|string $value
     *
     * @return SplObjectStorage
     */
    public static function findBy(PDO $pdo, string $column, int|string $value): SplObjectStorage
    {
        $selectStatement = $pdo->prepare("SELECT id, cinema_id, number, title from halls where {$column} = ?;");
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute([$value]);

        $collection = new SplObjectStorage();
        while ($result = $selectStatement->fetch()) {
            $model = (new self($pdo))
                ->setId($result['id'])
                ->setCinemaId($result['cinema_id'])
                ->setNumber($result['number'])
                ->setTitle($result['title']);

            $collection->attach($model);
        }

        return $collection;
    }

    /**
     * @param PDO $pdo
     *
     * @return SplObjectStorage
     */
    public static function all(PDO $pdo): SplObjectStorage
    {
        $selectStatement = $pdo->prepare('SELECT id, cinema_id, number, title from halls;');
        $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStatement->execute();

        $collection = new SplObjectStorage();
        while ($result = $selectStatement->fetch()) {
            $model = (new self($pdo))
                ->setId($result['id'])
                ->setCinemaId($result['cinema_id'])
                ->setNumber($result['number'])
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
        $offset = 0;
        $mediator = [];
        $limit = static::OFFSET;

        do {
            $selectStatement = $pdo->prepare("SELECT id, cinema_id, number, title from halls LIMIT {$limit} OFFSET {$offset};");
            $selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
            $selectStatement->execute();

            $result = $selectStatement->fetchAll();
            foreach ($result as $value) {
                $mediator[] = [
                    'id' => $value['id'],
                    'cinema_id' => $value['cinema_id'],
                    'number' => $value['number'],
                    'title' => $value['title'],
                ];
            }

            $offset += static::OFFSET;
        } while ($result);

        yield $mediator;
    }
}
