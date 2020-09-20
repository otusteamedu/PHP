<?php

namespace View;

class WrongUserInputView extends View
{
    public function output()
    {
        echo '<h5>Имя канала (пользователя) не может быть более 150 символов</h5>';
    }
}