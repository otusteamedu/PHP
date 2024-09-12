<?php


namespace HW;


use HW\validators\Validator;
use HW\validators\ValidatorDns;
use HW\validators\ValidatorSyntax;

class App
{
    /** @var Validator[]  */
    private $validators = [];

    public function __construct()
    {
        $this->validators[] = new ValidatorSyntax();//mandatory
        //optional
        $this->validators[] = new ValidatorDns();

    }


    /**
     * output result in json
     */
    public function validate()
    {
        $emails = $_REQUEST['emails'];

        if (!is_array($emails))
            $emails = [$emails];

        $result = [];

        foreach ($emails as $email)
        {
            $isValid = true;

            foreach ($this->validators as $validator)
            {
                $isValid = $validator->validate($email);
                if (!$isValid)
                    break;
            }
            $result[$email] = $isValid;
        }

        echo json_encode($result);
    }

}