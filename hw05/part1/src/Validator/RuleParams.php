<?php

namespace App\Validator;

class RuleParams
{
    /** @var string */
    public $name;
    /** @var array */
    public $params = [];

    /**
     * @param string $name
     * @param array $params
     */
    public function __construct(string $name, array $params = [])
    {
        $this->name = $name;
        $this->params = $params;
    }


    /**
     * @param string $str
     * @return RuleParams|null
     */
    public static function parse(string $str): ?RuleParams
    {
        if (empty($str)) {
            return null;
        }

        if (strpos($str, ':') === false) {
            return new RuleParams($str);
        }

        $explodedStr = explode(':', $str);

        return new RuleParams(
            $explodedStr[0],
            explode(',', $explodedStr[1])
        );
    }
}
