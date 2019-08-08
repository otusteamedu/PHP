<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper;

use Otus\hw22\Model\{Post, User};

interface PostMapperInterface
{
    /**
     * @param int $postId
     * @return Post
     */
    public function getPost(int $postId): Post;

    /**
     * @param Post $post
     * @return bool
     */
    public function savePost(Post $post): bool;

    /**
     * @param int $postId
     * @return bool
     */
    public function deletePost(int $postId): bool;

    /**
     * @param User $author
     * @return array
     */
    public function getPostsByAuthor(User $author): array;
}