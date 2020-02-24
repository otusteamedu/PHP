<?php

namespace App\Entities;

use App\Kernel\App;

class TypeTree
{
    /**
     * @var \NestedSet
     */
    protected $treeModel;

    public function __construct()
    {
        $this->pdo = App::getInstance('pdo');
        $this->treeModel = new \NestedSet($this->pdo);
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