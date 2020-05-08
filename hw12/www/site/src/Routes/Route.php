<?php

namespace App\Routes;

use App\Controllers\PostController;
use App\Controllers\CategoryController;
use Klein\Klein;

class Route
{
    /**
     * @var Klein
     */
    private Klein $router;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new Klein();
    }

    public function init(): void
    {
        $this->router->respond('GET', '/generate-data', static function () {
            return (new PostController())->generateData();
        });
        $this->router->respond('GET', '/posts', static function () {
            return (new PostController)->getPosts();
        });
        $this->router->respond('DELETE', '/post', static function ($request) {
            return (new PostController)->deletePost($request);
        });
        $this->router->respond('POST', '/post', static function ($request) {
            return (new PostController)->insertPost($request);
        });

        $this->router->respond('PATCH', '/post', static function ($request) {
            return (new PostController)->updatePost($request);
        });

        $this->router->respond('GET', '/categories', static function () {
            return (new CategoryController())->getCategory();
        });
        $this->router->respond('DELETE', '/category', static function ($request) {
            return (new CategoryController)->deleteCategory($request);
        });
        $this->router->respond('POST', '/category', static function ($request) {
            return (new CategoryController)->insertCategory($request);
        });
        $this->router->respond('PATCH', '/category', static function ($request) {
            return (new CategoryController)->updateCategory($request);
        });

        $this->router->dispatch();
    }
}