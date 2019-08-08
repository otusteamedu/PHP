<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Exception\NotFoundException;
use Otus\hw22\Mapper\Relation;
use Otus\hw22\Mapper\UserMapperInterface;
use Otus\hw22\Model\User;

class UserMapper extends AbstractMapper implements UserMapperInterface
{
    protected function createUser(array $data): User
    {
        $user = new User($data);
        $this->createPostRelation($user);
        $this->createCommentsRelation($user);

        return $user;
    }

    protected function createPostRelation(User $user): Relation
    {
        $post = new Relation(
            new PostMapper($this->pdo),
            'getPostsByAuthor',
            $user
        );
        $user->setRelation('posts', $post);

        return $post;
    }

    protected function createCommentsRelation(User $user): Relation
    {
        $comments = new Relation(
            new CommentMapper($this->pdo),
            'getCommentsByUser',
            $user
        );

        $user->setRelation('comments', $comments);

        return $comments;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User
    {
        $query = $this->pdo->prepare("SELECT * FROM user WHERE id=:id");

        if (!$query) {
            throw new \PDOException("Invalid query");
        }

        $query->execute([
            ':id' => $id
        ]);

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            throw new NotFoundException(sprintf("User not found. User ID: %d", $id));
        }

        return $this->createUser($data);
    }
}