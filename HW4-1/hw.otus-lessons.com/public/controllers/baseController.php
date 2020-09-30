<?php


namespace App\Controllers;


use App\Util;

class baseController extends ModelController
{
    public function index()
    {
        Util::pre('Check. This is Base Controller');
    }
}