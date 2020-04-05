<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;

class SiteController extends BaseController
{
    public function indexAction(): string
    {
        return $this->render('site/index.twig', ['name' => 'Fabien']);
    }
}
