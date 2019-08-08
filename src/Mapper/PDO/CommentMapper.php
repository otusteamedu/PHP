<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Mapper\CommentInterface;
use Otus\hw22\Mapper\Post;
use Otus\hw22\Mapper\Relation;
use Otus\hw22\Mapper\User;
use Otus\hw22\Model\Comment;

class CommentMapper extends AbstractMapper implements CommentInterface
{
    public function init(): void
    {
        $this->relations['user'] = new Relation(new UserMapper($this->pdo), 'getUser');
        $this->relations['post'] = new Relation(new PostMapper($this->pdo), 'getPost');
    }

    protected function setPostRelation(Comment $comment): void
    {
        $comment->setRelation('post', $this->relations['post']->setArgs($comment->getPostId()));
    }

    protected function setUserRelation(Comment $comment): void
    {
        $comment->setRelation('user', $this->relations['user']->setArgs($comment->getUserId()));
    }

    protected function createComment(array $data = []): Comment
    {
        $comment = new Comment($data);
        $this->setUserRelation($comment);
        $this->setPostRelation($comment);

        return $comment;
    }

    public function getCommentsByUser(User $user): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comment WHERE user_id=:user_id");
        $found = $query->execute([
            ':user_id' => $user->getId()
        ]);

        if (!$found) {
            return [];
        }

        $comments = [];
        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $comment = new Comment($row);
            $comment->setUser($user);
            $this->setPostRelation($comment);
            $comments[] = $comment;
        }

        return $comments;
    }

    public function getCommentsOfPost(Post $post): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comment WHERE post_id=:post_id");
        $found = $query->execute([
            ':post_id' => $post->getId()
        ]);

        if (!$found) {
            return [];
        }

        $comments = [];
        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $comment = new Comment($row);
            $this->setUserRelation($comment);
            $comment->setPost($post);
            $comments[] = $comment;
        }

        return $comments;
    }
}