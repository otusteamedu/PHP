<?php
namespace App;
use App\Database;
use App\ActiveRecord;

class LazyLoad {
    protected $class = null;

    public function getActiveRecord() {
        if ($this->class == null) {
            $db=Database::init();
            $this->class = new ActiveRecord($db);
        }
        return $this->class;
    }
}