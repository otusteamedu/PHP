<?php
require 'vendor/autoload.php';

use Otus\hw22\Mapper\PDO\PostMapper;

$pdo = new PDO('sqlite:/db/test.sql');
$postMapper = new PostMapper($pdo);
$post = $postMapper->getPost(1);

foreach ($post->getComments() as $comment) {
    //print comment
}