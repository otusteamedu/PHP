<?php

namespace Tirei01\Hw12\Mvc\Controller;

class Admin extends \Tirei01\Hw12\Mvc\Controller
{

    public function index()
    {
        $this->title = 'Административный разде';
        $this->data = array(
            'title' => 'Административный разде',
            'menu_list' => array(
                array('url' => '/admin/category/', 'name' => 'Категории'),
                array('url' => '/admin/property/', 'name' => 'Свойства'),
                array('url' => '/admin/element/', 'name' => 'Элементы'),
                array('url' => '/admin/generate/', 'name' => 'Создать 1000 фильмов'),
            ),
        );
    }

}