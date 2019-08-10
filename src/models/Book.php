<?php


namespace hw23\models;


use hw23\db\ActiveRecord;

/**
 * Class Book
 * @package hw23\models
 *
 * @property $id int
 * @property $composition_id int
 * @property $publisher_id int
 * @property $enabled int
 * @property $created_at string
 * @property $updated_at string
 * @property $deleted_at string
 */
class Book extends ActiveRecord
{
    public $id;
    public $composition_id;
    public $publisher_id;
    public $enabled;
    public $created_at;
    public $updated_at;
    public $deleted_at;

}