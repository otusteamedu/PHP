<?php

namespace VideoPlatform\models;

abstract class ActiveRecord
{
    abstract public function findById($id);
}