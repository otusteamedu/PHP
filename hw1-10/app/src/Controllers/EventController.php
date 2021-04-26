<?php
namespace Src\Controllers;

use Klein\Request;
use Src\Exceptions\DataBaseException;
use Src\Services\EventService;

/**
 * Class EventController
 *
 * @package Src\Controllers
 */
class EventController
{
    /**
     * @param \Klein\Request $request
     *
     * @return string
     * @throws \Exception
     */
    public function add(Request $request): string
    {
        return (new EventService())->insertData($request);
    }

    /**
     * @return string
     * @throws DataBaseException
     */
    public function delete(): string
    {
        return (new EventService())->deleteData();
    }

    /**
     * @return string
     */
    public function getList(): string
    {
        return (new EventService())->getListData();
    }

    /**
     * @param \Klein\Request $request
     *
     * @return string
     * @throws DataBaseException
     */
    public function search(Request $request): string
    {
        return (new EventService())->searchData($request);
    }
}