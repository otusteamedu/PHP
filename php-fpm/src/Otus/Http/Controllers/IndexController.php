<?php


namespace Otus\Http\Controllers;


class IndexController extends Controller
{
    public function index()
    {
        $query = $this->post();

        $this->response($query);
    }

}