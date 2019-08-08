<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper;

interface CommentInterface
{
    public function getCommentsByUser(User $user): array;

    public function getCommentsOfPost(Post $post): array;
}