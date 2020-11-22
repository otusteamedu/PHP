<?php

namespace eav;

interface IModel
{
    public function save();
    public function findByAttr($attrs = []);
    public function delete();
}