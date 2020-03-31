<?php
namespace Otus\HW11\Task1;

use \Otus\HW11\Task1;

class Request
{
    protected $route;
    protected $data;

    public function __construct($request)
    {
        if ( !is_null($request['action']) ) {
            $this->route = htmlentities( trim($request['action']) );
        }

        if ( !is_null($request['data']) ) {
            $this->data = trim($request['data']);
        }
    }


    /**
     * @return bool
     */
    public function isAddChannel(): bool
    {
        return ($this->route == 'addchannel') && ($_SERVER['REQUEST_METHOD'] == 'POST');
    }


    /**
     * @return bool
     */
    public function isAddVideo(): bool
    {
        return ($this->route == 'addvideo') && ($_SERVER['REQUEST_METHOD'] == 'POST');
    }


    /**
     * @return bool
     */
    public function isShowStatus(): bool
    {
        return ($this->route == 'showstatus') && ($_SERVER['REQUEST_METHOD'] == 'GET');
    }

    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return $this->data;
    }

}
