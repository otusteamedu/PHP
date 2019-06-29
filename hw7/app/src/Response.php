<?php
/**
* Response class for Email Checker App
*
* Checks emails and returns the result
*/
namespace App;

use \Jekys\Email;

class Response
{
    /**
    * @var boolean - store final response result
    */
    private $success = false;

    /**
    * @var string - store last error
    */
    private $error = 'Unknown error';

    /**
    * @var string - store passed action
    */
    private $action = '';

    /**
    * @var string - store passed email
    */
    private $email = '';

    /**
    * @var array - describe which method from Email lib has to be called for passed action
    */
    private $methods = [
        'check' => [
            'method' => 'check',
            'error' => 'Email is invalid or has no MX records'
        ],
        'is_valid' => [
            'method' => 'isValid',
            'error' => 'Email is invalid'
        ],
       'has_mx' => [
            'method' => 'hasMX',
            'error' => 'Email has no MX records'
        ]
    ];

    /**
    * Response object constructor
    *
    * Checks passed params, calls actions and sets final result
    *
    * @param string @email
    * @param string $action
    *
    * @return void
    */
    public function __construct(String $email, String $action)
    {
        $callAction = true;

        foreach (['email', 'action'] as $param) {
            if (empty(${$param})) {
                $this->error = $param.' param is empty';
                $callAction = false;

                break;
            } else {
                $this->{$param} = ${$param};
            }
        }

        if ($callAction) {
            $this->callAction();
        }
    }

    /**
    * Calls the action and sets final result according to Email lib response
    *
    * @return void
    */
    private function callAction()
    {
        if (array_key_exists($this->action, $this->methods)) {
            $action = $this->methods[$this->action];

            $this->success = Email::{$action['method']}($this->email);
            if ($this->success) {
                $this->error = '';
            } else {
                $this->error = $action['error'];
            }
        } else {
            $this->error = 'Unknown action';
        }
    }

    /**
    * Returns final results
    *
    * @return array
    */
    public function get()
    {
        return [
            'success' => $this->success,
            'error' => $this->error
        ];
    }
}
