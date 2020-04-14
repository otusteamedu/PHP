<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Video;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoController extends BaseController
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $rows = Video::find();

        ob_start();
        var_dump($rows);
        $content = ob_get_contents();

        return $this->getResponseSimple($content, 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $id = Video::add($request->getParsedBody());

        return $this->getResponseJson([
            'is_succeed' => true,
            'id' => $id,
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $modifiedCount = Video::update($data['filter'], $data['data']);

        return $this->getResponseJson([
            'is_succeed' => true,
            'modified_count' => $modifiedCount
        ], 200);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $deletedCount = Video::delete($data['filter']);

        return $this->getResponseJson([
            'is_succeed' => true,
            'deleted_count' => $deletedCount
        ],  200);
    }
}
