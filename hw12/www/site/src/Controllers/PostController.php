<?php


namespace App\Controllers;


use App\DB\Db;
use App\Messages\MessageWeb;
use App\Models\Post;
use App\TableDataGateway\PostGateway;
use JsonException;
use Klein\Request;

/**
 * Class PostController
 * @package App\Controllers
 */
class PostController
{
    public function generateData()
    {
        Db::generateData();
        try {
            return MessageWeb::sendOk(json_encode(['data' => 'Ok'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    public function getPosts()
    {
        $db = Db::get();

        $posts = (new PostGateway($db))->getAll();

        try {
            return MessageWeb::sendOk(json_encode(['data' => $posts], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    public function deletePost(Request $request)
    {
        $id = $request->param('id');

        $db = Db::get();
        $postGateway = (new PostGateway($db));
        $post = $postGateway->findById($id);

        if(!$post) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'post not fount'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }
        $isDelete = $postGateway->delete($post);

        if(!$isDelete)  {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'post is not removed'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'post removed'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }


    public function insertPost(Request $request)
    {
        try {
            $postData = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        $post = new Post();

        $post->setData($postData);

        $db = Db::get();
        $postGateway = (new PostGateway($db));

        $post = $postGateway->insert($post);

        if(!$post->getId()) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'post is not added'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'post added'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }


    public function updatePost(Request $request)
    {
        $id = $request->param('id');

        $db = Db::get();
        $postGateway = (new PostGateway($db));
        $post = $postGateway->findById($id);

        if(!$post) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'post not fount'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            $postData = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        $post->setData($postData);

        $isUpdate = $postGateway->update($post);

        if(!$isUpdate)  {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'post is not updated'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'post updated'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }


}