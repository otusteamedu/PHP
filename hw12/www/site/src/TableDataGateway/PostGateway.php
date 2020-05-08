<?php

namespace App\TableDataGateway;

use App\Models\Post;
use PDO;
use PDOStatement;

class PostGateway
{
    public static string $table = 'posts';

    private PDO $pdo;
    /**
     * @var bool|PDOStatement
     */
    private $selectStmt;
    /**
     * @var bool|PDOStatement
     */
    private $deleteStmt;
    /**
     * @var bool|PDOStatement
     */
    private $updateStmt;
    /**
     * @var bool|PDOStatement
     */
    private $insertStmt;
    /**
     * @var bool|PDOStatement
     */
    private $selectOneStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare('SELECT * FROM '.self::$table);

        $this->deleteStmt = $pdo->prepare('DELETE FROM ' .self::$table . ' WHERE id = :id');

        $this->selectOneStmt = $pdo->prepare('SELECT * FROM ' .self::$table . ' WHERE id = :id');

        $this->insertStmt = $pdo->prepare('INSERT INTO ' .self::$table . ' (title, text, category_id) values (:title, :text, :category_id)');

        $this->updateStmt = $pdo->prepare('UPDATE ' .self::$table . ' set title = :title, text = :text, category_id = :category_id where id = :id');
    }

    public function findById(int $id): ?Post
    {
        $this->selectOneStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectOneStmt->execute([
            'id' => $id
        ]);
        if (($result = $this->selectOneStmt->fetch()) === false) {
            return null;
        }

        $post = new Post();
        $post->setId($result['id']);
        $post->setTitle($result['title']);
        $post->setText($result['text']);
        $post->setCategory($result['category_id']);

        return $post;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->selectStmt->execute();

        $posts = [];
        foreach ($this->selectStmt->fetchAll() as $result) {
            $post = new Post();
            $post->setId($result['id']);
            $post->setTitle($result['title']);
            $post->setText($result['text']);
            $post->setCategory($result['category_id']);
            $posts[] = $post;
        }

        return $posts;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post)
    {
        return  $this->deleteStmt->execute([
           'id' => $post->getId()
        ]);
    }


    /**
     * @param Post $post
     * @return Post
     */
    public function insert(Post $post)
    {
        $this->insertStmt->execute([
            'title' => $post->getTitle(),
            'text' => $post->getText(),
            'category_id' => $post->getCategory(),
        ]);

        $post->setId((int)$this->pdo->lastInsertId());

        return $post;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function update(Post $post)
    {
        return $this->updateStmt->execute([
           'title' => $post->getTitle(),
            'text' => $post->getText(),
            'category_id' => $post->getCategory(),
           'id' => $post->getId()
        ]);
    }
}