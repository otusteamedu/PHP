<?php
/**
* Response class for Email Checker App
*
* Checks emails and returns the result
*/
namespace App;

use \Jekys\Email;

class ResponseHandler
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

        if (empty($email)) {
            $this->error = 'email param is empty';
            $callAction = false;
        } else {
            $this->email = $email;
        }

        if (empty($action)) {
            $this->error = 'action param is empty';
            $callAction = false;
        } else {
            $this->action = $action;
        }

        if ($callAction) {
            $this->callAction();
        }
    }

    /**
    * Calls the action and sets final result according to Email lib response
    *
    * @return boolean
    */
    private function callAction()
    {
        if (!array_key_exists($this->action, $this->methods)) {
            $this->error = 'Unknown action';

            return false;
        }

        $action = $this->methods[$this->action];

        if (!in_array($action['method'], get_class_methods('Jekys\\Email'))) {
            $this->error = 'Wrong class method';

            return false;
        }

        $this->success = Email::{$action['method']}($this->email);
        if ($this->success) {
            $this->error = '';
        } else {
            $this->error = $action['error'];
        }

        return $this->error;
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
