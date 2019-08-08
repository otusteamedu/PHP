<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Exception\NotFoundException;
use Otus\hw22\Mapper\Relation;
use Otus\hw22\Mapper\UserMapperInterface;
use Otus\hw22\Model\User;

class UserMapper extends AbstractMapper implements UserMapperInterface
{
    public function init(): void
    {
        $this->relations['posts'] = new Relation(
            new PostMapper($this->pdo),
            'getPostsByAuthor'
        );

        $this->relations['comments'] = new Relation(
            new CommentMapper($this->pdo),
            'getCommentsByUser'
        );
    }

    protected function createUser(array $data): User
    {
        $user = new User($data);
        $posts = $this->relations['posts']->setArgs($user);
        $comments = $this->relations['comments']->setArgs($user);
        $user->setRelation('posts', $posts);
        $user->setRelation('comments', $comments);
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User
    {
        $query = $this->pdo->prepare("SELECT FROM user WHERE id=:id");
        $result = $query->execute([
            ':id' => $id
        ]);

        if (!$result) {
            throw new NotFoundException(sprintf("User not found. User ID: %d", $id));
        }

        return $this->createUser($query->fetch(\PDO::FETCH_ASSOC));
    }
}