<?php


namespace AYakovlev\Controller;


use AYakovlev\Core\View;

class AboutmeController
{
    public function about()
    {
        View::render("about");
    }
}