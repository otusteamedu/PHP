<?php


namespace Otushw;

class View
{
    protected $data;
    protected $type;

    const ERROR = 'error';
    const STATUS = 'status';

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function show()
    {
        if ($this->type == self::ERROR) {
            echo $this->data . PHP_EOL;
        }
        if ($this->type == self::STATUS) {
            foreach ($this->data as $email => $status) {
                $suffix = '';
                if (empty($status)) {
                    $suffix = 'not ';
                }
                echo 'This email ' . $email . ' is ' . $suffix . 'valid' . PHP_EOL;
            }
        }
    }
}
