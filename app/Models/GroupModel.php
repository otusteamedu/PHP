<?php

namespace App\Models;

use App\Services\Dao\DataMapper\Group\Group;
use App\Services\Dao\GroupDaoService;

class GroupModel
{
    /**
     * @var GroupDaoService
     */
    protected GroupDaoService $dataAccess;

    public function __construct()
    {
        $this->dataAccess = new GroupDaoService();
    }

    /**
     * @return array
     */
    public function getAllGroups(): array
    {
        return $this->dataAccess->getAll();
    }

    /**
     * @param $id
     * @return Group
     */
    public function getGroup($id): Group
    {
        return $this->dataAccess->getGroup($id);
    }

}