<?php


namespace Marchenko;


class View
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function render($type)
    {
        if ($type == 'default') {
            foreach ($this->items as $email => $result) {
                echo "E-mail: $email = $result <br />";
            }
        } else {
            foreach ($this->items as $error) {
                echo "$error <br />";
            }
        }
    }
}
