<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Mapper\CommentInterface;
use Otus\hw22\Model\{Post, User, Comment};
use Otus\hw22\Mapper\Relation;

class CommentMapper extends AbstractMapper implements CommentInterface
{
    protected function createPostRelation(Comment $comment): Relation
    {
        $post = new Relation(
            new PostMapper($this->pdo),
            'getPost',
            $comment->getPostId()
        );
        $comment->setRelation('post', $post);

        return $post;
    }

    protected function createUserRelation(Comment $comment): Relation
    {
        $user = new Relation(
            new UserMapper($this->pdo),
            'getUser',
            $comment->getUserId()
        );
        $comment->setRelation('user', $user);

        return $user;
    }

    protected function createComment(array $data = []): Comment
    {
        $comment = new Comment($data);
        $this->createUserRelation($comment);
        $this->createPostRelation($comment);

        return $comment;
    }

    public function getCommentsByUser(User $user): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comment WHERE user_id=:user_id");
        $query->execute([
            ':user_id' => $user->getId()
        ]);

        $data = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return [];
        }

        $comments = [];
        foreach ($data as $row) {
            $comment = $this->createComment($row);
            $comment->setUser($user);
            $comments[] = $comment;
        }

        return $comments;
    }

    public function getCommentsOfPost(Post $post): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comment WHERE post_id=:post_id");
        $query->execute([
            ':post_id' => $post->getId()
        ]);

        $data = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return [];
        }

        $comments = [];
        foreach ($data as $row) {
            $comment = $this->createComment($row);
            $comment->setPost($post);
            $comments[] = $comment;
        }

        return $comments;
    }
}