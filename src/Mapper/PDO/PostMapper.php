<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Exception\NotFoundException;
use Otus\hw22\Mapper\PDO\Proxy\PostWithRelations;
use Otus\hw22\Mapper\PostMapperInterface;
use Otus\hw22\Mapper\Relation;
use Otus\hw22\Observer;
use Otus\hw22\Model\{Post, User};

class PostMapper extends AbstractMapper implements PostMapperInterface
{
    public function init(): void
    {
        $this->relations['author'] = new Relation(
            new UserMapper($this->pdo),
            'getUser'
        );

        $this->relations['comments'] = new Relation(
            new CommentMapper($this->pdo),
            'getCommentsOfPost'
        );
    }

    protected function createPost(array $data = []): Post
    {
        $post = new Post($data);
        $author = $this->relations['author']->setArgs($post->getAuthorId());
        $post->setRelation('author', $author);
        $comments = $this->relations['comments']->setArgs($post);
        $post->setRelation('comments', $comments);
        return $post;
    }

    /**
     * @param int $postId
     * @throws NotFoundException
     * @return Post
     */
    public function getPost(int $postId): Post
    {
        $query = $this->pdo->prepare('SELECT * FROM post WHERE id=:id');

        $exists = $query->execute([
            ':id' => $postId
        ]);

        if (!$exists) {
            throw new NotFoundException(sprintf("Post not found. Post ID: %d", $postId));
        }

        return $this->createPost($query->fetch(\PDO::FETCH_ASSOC));
    }

    public function savePost(Post $post): bool
    {
        if ($post->getId() !== null) {
            $query = $this->pdo->prepare('UPDATE post SET');

        }
    }

    /**
     * @param int $postId
     * @return bool
     */
    public function deletePost(int $postId): bool
    {
        $query = $this->pdo->prepare("DELETE FROM post WHERE id=:id");
        return $query->execute();
    }

    /**
     * @param User $author
     * @return array
     */
    public function getPostsByAuthor(User $author): array
    {
        $query = $this->pdo->prepare("SELECT * FROM post WHERE author_id=:author_id");
        $found = $query->execute([
            ':author_id' => $author->getId()
        ]);

        if (!$found) {
            return [];
        }

        $posts = [];
        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $post = new Post($row);
            $post->setAuthor($author);
            $posts[] = $post;
        }

        return $posts;
    }
}