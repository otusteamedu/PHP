<?php

namespace Src\Models;

use PDO;
use Src\Repositories\ActiveRecord;

class Post extends ActiveRecord
{
    private ?int $post_id;

    private string $title;

    private string $text;

    private \PDOStatement $updateStmt;

    private \PDOStatement $insertStmt;

    private \PDOStatement $deleteStmt;

    private static string $selectAllQuery = "select * from posts";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->insertStmt = $pdo->prepare(
            "insert into posts (title, text) values (?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update posts set title = ?, text =  where post_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from posts where post_id = ?");
    }

    public static function tableName(): string
    {
        return 'posts';
    }

    public function getPostId(): int
    {
        return $this->post_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setPostId(int $post_id): self
    {
        $this->post_id = $post_id;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->title,
            $this->text
        ]);
        $this->post_id = $this->pdo->lastInsertId();
        return $result;
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->title,
            $this->text,
            $this->post_id
        ]);
    }

    public function delete(): bool
    {
        $id = $this->post_id;
        $this->post_id = null;
        return $this->deleteStmt->execute([$id]);
    }

    public static function getAll(PDO $PDO): array
    {
        $selectStmt = $PDO->prepare(self::$selectAllQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();

        if (!empty($result)) {
            return array_map(function ($post) use ($PDO, $result) {
                return (new self($PDO))
                    ->setPostId($post['post_id'])
                    ->setTitle($post['title'])
                    ->setText($post['text']);
            }, $result);
        }
        return [];
    }
}