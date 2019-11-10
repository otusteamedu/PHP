<?php

declare(strict_types=1);

namespace RowDataGateway\Gateways;

use PDO;

class GenreGateway extends AbstractGateway
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $title;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->insertStmt = $this->pdo->prepare('insert into genres (title) values (?)');
        $this->updateStmt = $this->pdo->prepare('update genres set title=:title where id=:id');
        $this->deleteStmt = $this->pdo->prepare('delete from genres where id=?');
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStmt->execute([$this->title]);
        $this->id = $this->pdo->lastInsertId();

        return (int)$this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            'id' => $this->id,
            'title' => $this->title,
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStmt->execute($this->id);

        $this->id = null;

        return $result;
    }
}