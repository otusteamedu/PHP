<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp;

use Nlazarev\Hw2_1\Model\AppEmailValidation\Config\IConfig;
use Nlazarev\Hw2_1\Model\General\String\StringObject;

final class RegExp extends StringObject implements IRegExp
{
    public function fromConfig(IConfig $conf)
    {
        $spec_symb_key = "{{spec_symb}}";
        $unicode_key = "{{unicode}}";

        $patern = $conf->getValueByKey('app.email_regexp.patern');

        $spec_symb_string = "";

        foreach ($conf->getValueByKey('app.email_regexp.options.spec_symb') as $key => $value) {
            if ($value['usage'] == 1) {
                $spec_symb_string .= $value['string'];
            }
        }

        $unicode_string = "";

        foreach ($conf->getValueByKey('app.email_regexp.options.unicode') as $key => $value) {
            if ($value['usage'] == 1) {
                $unicode_string .= $value['string'];
            }
        }

        $regexp_string = str_replace($spec_symb_key, $spec_symb_string, $patern);
        $regexp_string = str_replace($unicode_key, $unicode_string, $regexp_string);

        $this->setValue($regexp_string);
    }
}
