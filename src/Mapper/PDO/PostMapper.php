<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Exception\NotFoundException;
use Otus\hw22\Mapper\PostMapperInterface;
use Otus\hw22\Mapper\Relation;
use Otus\hw22\Model\{Post, User};

class PostMapper extends AbstractMapper implements PostMapperInterface
{
    protected function createPost(array $data = []): Post
    {
        $post = new Post($data);
        $this->createUserRelation($post);
        $this->createCommentsRelation($post);
        return $post;
    }

    protected function createUserRelation(Post $post): Relation
    {
        $author = new Relation(
            new UserMapper($this->pdo),
            'getUser',
            $post->getAuthorId()
        );
        $post->setRelation('author', $author);

        return $author;
    }

    protected function createCommentsRelation(Post $post): Relation
    {
        $comments = new Relation(
            new CommentMapper($this->pdo),
            'getCommentsOfPost',
            $post
        );
        $post->setRelation('comments', $comments);

        return $comments;
    }

    /**
     * @param int $postId
     * @throws NotFoundException
     * @return Post
     */
    public function getPost(int $postId): Post
    {
        $query = $this->pdo->prepare('SELECT * FROM post WHERE id=:id');

        $query->execute([
            ':id' => $postId
        ]);

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            throw new NotFoundException(sprintf("Post not found. Post ID: %d", $postId));
        }

        return $this->createPost($data);
    }

    public function savePost(Post $post): bool
    {
        //TODO update post if $post->getId() is not null, insert otherwise
    }

    /**
     * @param int $postId
     * @return bool
     */
    public function deletePost(int $postId): bool
    {
        $query = $this->pdo->prepare("DELETE FROM post WHERE id=:id");
        return $query->execute([
            ':id' => $postId
        ]);
    }

    /**
     * @param User $author
     * @return array
     */
    public function getPostsByAuthor(User $author): array
    {
        $query = $this->pdo->prepare("SELECT * FROM post WHERE author_id=:author_id");
        $query->execute([
            ':author_id' => $author->getId()
        ]);

        $data = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return [];
        }

        $posts = [];
        foreach ($data as $row) {
            $post = $this->createPost($row);
            $post->setAuthor($author);
            $posts[] = $post;
        }

        return $posts;
    }
}