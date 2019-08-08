<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper;

use Otus\hw22\Model\Post;
use Otus\hw22\Model\User;

interface CommentInterface
{
    public function getCommentsByUser(User $user): array;

    public function getCommentsOfPost(Post $post): array;
}