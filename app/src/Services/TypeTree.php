<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager;

class TypeTree
{
    /**
     * @var \NestedSet
     */
    protected $treeModel;

    public function __construct()
    {
        $this->treeModel = new \NestedSet(Manager::connection());
        $this->treeModel->changeTable('type');
    }

    /**
     * @return \NestedSet
     */
    public function getTreeModel(): \NestedSet
    {
        return $this->treeModel;
    }

    /**
     * @param \NestedSet $treeModel
     */
    public function setTreeModel(\NestedSet $treeModel): void
    {
        $this->treeModel = $treeModel;
    }
}