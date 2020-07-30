<?php

namespace Classes\Dto;

/**
 * @property int $id
 * @property string $message
 */

class PushDtoBuilder
{
    private $errors;

    private $id;
    private $message;


    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return PushDto::build($this);
    }

    public function validate()
    {
        if (empty($this->id)) {
            $this->errors[] = 'Не задан id клиента';
        }

        if (empty($this->message)) {
            $this->errors[] = 'Не задано сообщение';
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
