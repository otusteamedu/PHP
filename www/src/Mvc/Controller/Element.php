<?php

namespace Tirei01\Hw12\Mvc\Controller;

use Tirei01\Hw12\Storage\Mapper\Value;

class Element extends Property
{
    private \Tirei01\Hw12\Storage\Mapper\Element $mapElement;
    private \Tirei01\Hw12\Storage\Mapper\Value $mapValue;

    public function __construct($model)
    {
        $this->mapElement = new \Tirei01\Hw12\Storage\Mapper\Element();
        $this->mapValue = new Value();
        parent::__construct($model);
    }

    /**
     * @return Value
     */
    public function getValuerMap()
    {
        return $this->mapValue;
    }

    /**
     * @return \Tirei01\Hw12\Storage\Mapper\Element
     */
    public function getElementMap(): \Tirei01\Hw12\Storage\Mapper\Element
    {
        return $this->mapElement;
    }

    public function index()
    {
        $this->title = 'Административный раздел:Елементы';
        $obElemCollection = $this->getElementMap()->findAll();
        $this->data['elements'] = array();
        $this->data['elements'][] = array(
            'url' => '/admin/element/edit/0/',
            'name' => 'Добавить элемент',
        );
        /** @var \Tirei01\Hw12\Storage\Element $obElement */
        foreach ($obElemCollection as $obElement) {
            $codeCat = $obElement->getCategory()->getCode();
            $nameCat = $obElement->getCategory()->getName();
            $idCat = $obElement->getCategory()->getId();
            if(!$this->data['elements'][$codeCat]['name']){
                $this->data['elements'][$codeCat]['name'] = $nameCat;
                $this->data['elements'][$codeCat]['url'] = '/admin/category/edit/'.$idCat.'/';
            }
            $this->data['elements'][$codeCat]['elems'][] = array(
                'url' => '/admin/element/edit/' . $obElement->getId() . '/',
                'name' => $obElement->getName(),
            );
        }
        $this->data['back_url'] = '/admin/';
    }

    public function edit()
    {
        $id = (int)$this->getModel()->getParam('id');
        $this->title = 'Административный раздел:Категории:Добавить новую категорию.';
        if ($_POST['action'] === 'edit_element') {
            $arPropField = $_POST['prop'];
            $obCategory = $this->getCategoryMap()->find($_POST['category_id']);
            $obElement = new \Tirei01\Hw12\Storage\Element(
                $id, $_POST['elem']['name'], $obCategory, $_POST['elem']['sort'], $_POST['elem']['code'],
            );
            $updElement = $this->getElementMap();
            if ($id > 0) {
                $updElement->update($obElement);
            } else {
                $updElement->insert($obElement);
            }
            $obCollectOfProps = $this->getPropertyMap()->findByCategory($obCategory);
            /**@var \Tirei01\Hw12\Storage\Property $obCollectOfProp */
            foreach ($obCollectOfProps as $obCollectOfProp) {
                $code = $obCollectOfProp->getCode();
                if (array_key_exists($code, $arPropField)) {
                    $value = $arPropField[$code];
                    $obValue = $this->getValuerMap()->findByElem($obElement, $obCollectOfProp);
                    if ($obValue === null) {
                        $obValue = new \Tirei01\Hw12\Storage\Value(
                            0, $obCollectOfProp, $obElement, null, $obCategory
                        );
                    }
                    $obValue->setValue($value);
                    if ($obValue->getId() === 0) {
                        $this->getValuerMap()->insert($obValue);
                    } else {
                        $this->getValuerMap()->update($obValue);
                    }
                }
            }
            if ($obElement->getId() > 0) {
                $redirect = "Location: /admin/element/edit/" . $obElement->getId() . '/';
                $this->setRedirect($redirect);
            }
        } elseif ($id > 0) {
            /** @var \Tirei01\Hw12\Storage\Element $obElement */
            $obElement = $this->getElementMap()->find($id);
            $this->data = array(
                'id' => $obElement->getId(),
                'name' => $obElement->getName(),
                'code' => $obElement->getCode(),
                'sort' => $obElement->getSort(),
                'category_id' => $obElement->getCategory()->getId(),
                'category_name' => $obElement->getCategory()->getName(),
            );
            $this->data['category'] = array(
                'id' => $obElement->getCategory()->getId(),
                'name' => $obElement->getCategory()->getName(),
            );
            $obProperties = $this->getPropertyMap()->findByCategory($obElement->getCategory());
            /** @var \Tirei01\Hw12\Storage\Property $obProperty */
            foreach ($obProperties as $obProperty) {
                /**@var \Tirei01\Hw12\Storage\Value $obValue */
                $obValue = $this->getValuerMap()->findByElem($obElement, $obProperty);
                if ($obValue === null) {
                    $obValue = new \Tirei01\Hw12\Storage\Value(
                        0, $obProperty, $obElement, null, $obElement->getCategory()
                    );
                }
                $this->data['properties'][$obProperty->getCode()] = array(
                    'value_id' => $obValue->getId(),
                    'value' => $obValue->getValue(),
                    'property_type' => $obValue->getProperty()->getType(),
                    'property_name' => $obValue->getProperty()->getName(),
                );
            }
            $this->title = 'Административный раздел:Категории:' . $obElement->getName();
        } elseif ($id === 0) {
            $obCatergoryCollection = $this->getCategoryMap()->findAll();
            foreach ($obCatergoryCollection as $obCategory) {
                $this->data['category'][] = array(
                    'id' => $obCategory->getId(),
                    'name' => $obCategory->getName(),
                );
            }
            $this->data['id'] = $id;
        }
        $this->data['back_url'] = '/admin/element/';
    }

}