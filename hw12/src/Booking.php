<?php

/**
 * Lazy load
 */

namespace HW;


use HW\ActiveRecords\Session;

class Booking
{
    /** @var Session[]  */
    private $sessions = [];


    public function getSessions($hallID)
    {
        if (!isset($this->sessions[$hallID]))
            $this->sessions[$hallID] = Session::getAll($hallID);

        return $this->sessions[$hallID];
    }




}