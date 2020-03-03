<?php

namespace Tirei01\Hw12\Mvc\Controller;

use Tirei01\Hw12\Mvc\Controller;

class Category extends Controller
{
    private \Tirei01\Hw12\Storage\Mapper\Category $mapCategory;

    public function __construct($model)
    {
        $this->mapCategory = new \Tirei01\Hw12\Storage\Mapper\Category();
        parent::__construct($model);
    }

    protected function getCategoryMap(): \Tirei01\Hw12\Storage\Mapper\Category
    {
        return $this->mapCategory;
    }

    public function index()
    {
        $this->title = 'Административный раздел:Категории';
        $obCatergoryCollection = $this->getCategoryMap()->findAll();
        $this->data['elements'] = array();
        $this->data['elements'][] = array(
            'url' => '/admin/category/edit/0/',
            'name' => 'Добавить категорию',
        );
        foreach ($obCatergoryCollection as $obCategory) {
            $this->data['elements'][] = array(
                'url' => '/admin/category/edit/' . $obCategory->getId() . '/',
                'name' => $obCategory->getName(),
            );
        }
        $this->data['back_url'] = '/admin/';
    }

    public function edit()
    {
        $id = $this->getModel()->getParam('id');
        $this->title = 'Административный раздел:Категории:Добавить новую категорию.';
        if ($_POST['action'] === 'edit_category') {
            $obCategory = new \Tirei01\Hw12\Storage\Category(
                $id, $_POST['name'], $_POST['sort'], $_POST['code'],
            );
            $updCategory = $this->getCategoryMap();
            if ($id > 0) {
                $updCategory->update($obCategory);
            } else {
                $updCategory->insert($obCategory);
            }
            if ($obCategory->getId() > 0) {
                $redirect = "Location: /admin/category/edit/" . $obCategory->getId() . '/';
                $this->setRedirect($redirect);

            }
        } elseif ($id > 0) {
            /** @var \Tirei01\Hw12\Storage\Category $obCategory */
            $obCategory = $this->getCategoryMap()->find($id);
            $this->data = array(
                'id' => $obCategory->getId(),
                'name' => $obCategory->getName(),
                'code' => $obCategory->getCode(),
                'sort' => $obCategory->getSort(),
            );
            $this->title = 'Административный раздел:Категории:' . $obCategory->getName();
        }
        $this->data['back_url'] = '/admin/category/';
    }
}