<?php

namespace Tirei01\Hw12\Mvc\Controller;

use Tirei01\Hw12\Mvc\Controller;
use Tirei01\Hw12\Storage\Value;

class Property extends Category
{
    private \Tirei01\Hw12\Storage\Mapper\Property $map;

    public function __construct($model)
    {
        $this->map = new \Tirei01\Hw12\Storage\Mapper\Property();
        parent::__construct($model);
    }

    protected function getPropertyMap(): \Tirei01\Hw12\Storage\Mapper\Property
    {
        return $this->map;
    }

    public function index()
    {
        $this->title = 'Административный раздел:Свойства';
        $obElemCollection = $this->getPropertyMap()->findAll();
        $this->data['elements'] = array();
        $this->data['elements'][] = array(
            'url' => '/admin/property/edit/0/',
            'name' => 'Добавить новое свойство',
        );
        /** @var \Tirei01\Hw12\Storage\Property $obProperty */
        foreach ($obElemCollection as $obProperty) {
            $codeCat = $obProperty->getCategory()->getCode();
            $nameCat = $obProperty->getCategory()->getName();
            $idCat = $obProperty->getCategory()->getId();
            if(!$this->data['elements'][$codeCat]['name']){
                $this->data['elements'][$codeCat]['name'] = $nameCat;
                $this->data['elements'][$codeCat]['url'] = '/admin/category/edit/'.$idCat.'/';
            }
            $this->data['elements'][$codeCat]['elems'][] = array(
                'url' => '/admin/property/edit/' . $obProperty->getId() . '/',
                'name' => $obProperty->getName(),
            );
        }
        $this->data['back_url'] = '/admin/';
    }

    public function edit()
    {
        $id = (int) $this->getModel()->getParam('id');
        $this->title = 'Административный раздел:Категории:Добавить новое свойство.';
        if ($_POST['action'] === 'edit_property') {
            $obCategory = $this->getCategoryMap()->find($_POST['category_id']);
            $obProperty = new \Tirei01\Hw12\Storage\Property(
                $id,
                $_POST['name'],
                $_POST['type'],
                $obCategory,
                $_POST['sort'],
                $_POST['code'],
            );
            $updCategory = $this->getPropertyMap();
            if ($id > 0) {
                $updCategory->update($obProperty);
            } else {
                $updCategory->insert($obProperty);
            }
            if ($obProperty->getId() > 0) {
                $redirect = "Location: /admin/property/edit/" . $obProperty->getId() . '/';
                $this->setRedirect($redirect);

            }
        } elseif ($id > 0) {
            /** @var \Tirei01\Hw12\Storage\Property $obProperty */
            $obProperty = $this->getPropertyMap()->find($id);
            $this->data = array(
                'id' => $obProperty->getId(),
                'name' => $obProperty->getName(),
                'code' => $obProperty->getCode(),
                'sort' => $obProperty->getSort(),
                'type' => $obProperty->getType(),
            );
            $this->data['category'] = array(
                'id' => $obProperty->getCategory()->getId(),
                'name' => $obProperty->getCategory()->getName(),
            );
            $this->title = 'Административный раздел:Категории:' . $obProperty->getName();
        }elseif ($id === 0){
            $obCatergoryCollection = $this->getCategoryMap()->findAll();
            foreach ($obCatergoryCollection as $obCategory) {
                $this->data['category'][] = array(
                    'id' => $obCategory->getId(),
                    'name' => $obCategory->getName(),
                );
                $this->data['id'] = 0;
            }
        }
        $this->data['back_url'] = '/admin/property/';
        $this->data['types'] = \Tirei01\Hw12\Storage\Property::getTypes();
    }
}