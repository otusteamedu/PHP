<?php

namespace Validate;

use Validate\Rule\Rules\Mx;
use Validate\Rule\Rules\Pattern;

final class Validate {

    protected function valid($email)
    {
        echo "Email \"" . $email ."\" is valid<br>";
    }

    protected function notValid($email)
    {
        echo "Email \"" . $email ."\" is not valid<br>";
    }

    /**
     * Валидация входящего значения
     *
     * @param $string
     */
    public function validate(string $email): void
    {

        $mx = new Mx();
        $pattern = new Pattern();

        if ($pattern->check($email)) {
            $this->valid($email);
        } else {
            $this->notValid($email);
        }

    }


}