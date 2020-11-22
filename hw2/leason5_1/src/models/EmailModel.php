<?php

namespace models;
/**
 * Class EmailModel
 *
 * @package models
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class EmailModel extends CBaseModel
{
    public $email;


    public function rules()
    {
        return [
            ['email', 'CEmailValidator', 'checkMX' => true],
        ];
    }
}