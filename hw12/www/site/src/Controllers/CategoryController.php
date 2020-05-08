<?php


namespace App\Controllers;


use App\DB\Db;
use App\Messages\MessageWeb;
use App\Models\Category;
use App\TableDataGateway\CategoryGateway;
use JsonException;
use Klein\Request;

class CategoryController
{

    public function getCategory()
    {
        $db = Db::get();

        $categories = (new CategoryGateway($db))->getAll();

        try {
            return MessageWeb::sendOk(json_encode(['data' => $categories], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->param('id');

        $db = Db::get();
        $categoryGateway = (new CategoryGateway($db));
        $category = $categoryGateway->findById($id);

        if(!$category) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'category not found'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }
        $isDelete = $categoryGateway->delete($category);

        if(!$isDelete)  {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'category is not removed'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'category removed'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }


    public function insertCategory(Request $request)
    {
        try {
            $categoryData = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        $category = new Category();

        $category->setData($categoryData);

        $db = Db::get();
        $categoryGateway = (new CategoryGateway($db));

        $category = $categoryGateway->insert($category);

        if(!$category->getId()) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'category is not added'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'category added'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }


    public function updateCategory(Request $request)
    {
        $id = $request->param('id');

        $db = Db::get();
        $categoryGateway = (new CategoryGateway($db));
        $category = $categoryGateway->findById($id);

        if(!$category) {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'category not found'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            $postData = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }

        $category->setData($postData);

        $isUpdate = $categoryGateway->update($category);

        if(!$isUpdate)  {
            try {
                return MessageWeb::sendError(json_encode(['error' => 'category is not updated'], JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                return MessageWeb::sendError($e->getMessage());
            }
        }

        try {
            return MessageWeb::sendOk(json_encode(['data' => 'category updated'], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return MessageWeb::sendError($e->getMessage());
        }
    }
}