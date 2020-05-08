<?php

namespace App\TableDataGateway;

use App\Models\Category;
use App\Models\Post;
use PDO;
use PDOStatement;

class CategoryGateway
{
    public static string $table = 'categories';

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
    private $findPostsStmt;
    /**
     * @var bool|PDOStatement
     */
    private $selectOneStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare('SELECT * FROM '.self::$table);

        $this->deleteStmt = $pdo->prepare('DELETE FROM ' .self::$table . ' WHERE id = :id');

        $this->insertStmt = $pdo->prepare('INSERT INTO ' .self::$table . ' (title) values (:title)');

        $this->selectOneStmt = $pdo->prepare('SELECT * FROM ' .self::$table . ' WHERE id = :id');

        $this->updateStmt = $pdo->prepare('UPDATE ' .self::$table . ' set title = :title where id = :id');

        $this->findPostsStmt = $pdo->prepare('SELECT * FROM ' .PostGateway::$table . ' WHERE category_id = :category_id');
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->selectStmt->execute();

        $categories = [];
        foreach ($this->selectStmt->fetchAll() as $result) {
            $category = new Category();
            $category->setId($result['id']);
            $category->setTitle($result['title']);
            $categories[] = $category;
        }

        return $categories;
    }

    /**
     * @param Category $category
     * @return bool
     */
    public function delete(Category $category)
    {
        return  $this->deleteStmt->execute([
            'id' => $category->getId()
        ]);
    }


    /**
     * @param Category $category
     * @return Category
     */
    public function insert(Category $category)
    {
        $this->insertStmt->execute([
            'title' => $category->getTitle(),
        ]);

        $category->setId((int)$this->pdo->lastInsertId());

        return $category;
    }

    /**
     * @param Category $category
     * @return bool
     */
    public function update(Category $category)
    {
        return $this->updateStmt->execute([
            'title' => $category->getTitle(),
            'id' => $category->getId()
        ]);
    }

    /**
     * @param Category $category
     * @return array
     */
    public function getPosts(Category $category): array
    {
        $this->findPostsStmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->findPostsStmt->execute([
            'category_id' => $category->getId()
        ]);

        $posts = [];
        foreach ($this->findPostsStmt->fetchAll() as $result) {

            $post = new Post();
            $post->setId($result['id']);
            $post->setTitle($result['title']);
            $post->setText($result['text']);
            $post->setCategory($result['category_id']);
            $posts[] = $post;
        }


        return $posts;
    }

    public function findById(?string $id): ?Category
    {
        $this->selectOneStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneStmt->execute([
            'id' => $id
        ]);
        if (($result = $this->selectOneStmt->fetch()) === false) {
            return null;
        }

        $post = new Category();
        $post->setId($result['id']);
        $post->setTitle($result['title']);

        return $post;
    }
}