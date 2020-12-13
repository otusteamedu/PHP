<?php

namespace EmailValidator;

class EmailValidator {
    
    public function run($request = [])
    {
        $this->validate($request);
    }

    private function validate($request)
    {
        if (empty($request['emails']) and !is_array($request['emails'])) {
            throw new \Exception('something wrong with emails');
        }

        foreach($request['emails'] as $email) {
            getmxrr($email);
        }
    }
}