<?php

namespace Classes\Repositories;


use Classes\Database\DbConnection;

class YoutubeChannelRepository implements YoutubeRepository
{
    private $dbConnection;

    public function __construct(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function create()
    {

    }

    public function deleteById()
    {

    }

}
