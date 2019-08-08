<?php

declare(strict_types=1);

namespace Otus\hw22\Model;

class Comment extends BaseModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $post_id;

    /**
     * @var Post
     */
    private $post;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var
     */
    private $content;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->related('post');
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $relation = $this->getRelation('post');

        if ($relation) {
            $relation->setResult($post);
        }
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->related('user');
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $relation = $this->getRelation('user');

        if ($relation) {
            $relation->setResult($user);
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

}