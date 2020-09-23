<?php

namespace Nlazarev\Hw6\Model\Email;

use Noodlehaus\Config;

class EmailRegExp
{
    private $value = null;
    private $params = array(
                        'spec_symb_key' => "{{spec_symb}}",
                        'unicode_key' => "{{unicode}}",
                        'patern' => "",
                        'spec_symb_string' => "",
                        'unicode_string' => ""
    );


    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setFromJSONConf(string $params_json_path)
    {

        $conf = new Config($params_json_path);
 
        $this->params['patern'] = $conf->get('app.email_regexp.patern');
        $this->params['spec_symb_string'] =
            $this->getSpecSymbStringFromJSONConf($conf->get('app.email_regexp.options.spec_symb'));
        $this->params['unicode_string'] =
            $this->getUnicodeSymbStringFromJSONConf($conf->get('app.email_regexp.options.unicode'));
        
        $email_regexp_string = str_replace($this->params['spec_symb_key'],
                                            $this->params['spec_symb_string'],
                                            $this->params['patern']);
        $email_regexp_string = str_replace($this->params['unicode_key'],
                                            $this->params['unicode_string'],
                                            $email_regexp_string);
        $this->value = $email_regexp_string;
    }

    protected function getSpecSymbStringFromJSONConf(array $options_spec_symb): string
    {
        $spec_symb_string = "";

        foreach ($options_spec_symb as $key => $value) {
            if ($value['usage'] == 1) {
                $spec_symb_string .= $value['string'];
            }
        }

        return $spec_symb_string;
    }

    protected function getUnicodeSymbStringFromJSONConf(array $options_unicode): string
    {
        $unicode_string = "";

        foreach ($options_unicode as $key => $value) {
            if ($value['usage'] == 1) {
                $unicode_string .= $value['string'];
            }
        }

        return $unicode_string;
    }
}