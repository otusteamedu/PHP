<?php

namespace sources;

interface IGateway
{
    /**
     * Create new row
     * @return mixed
     */
    public function insert();


    /**
     * Update exists row
     * @return mixed
     */
    public function update();


    /**
     * Fetch exits row by primary key
     * @return mixed
     */
    public function fetch();


    /**
     * Delete row by primary key
     * @return mixed
     */
    public function delete();
}