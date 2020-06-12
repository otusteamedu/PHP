<?php

namespace App\Controller;

use App\Core\BaseWebController;
use App\Api\ValidatorInterface;
use App\Model\EmailCompositeValidator;

class EmailValidatorController extends BaseWebController
{
    public function indexAction()
    {
        return $this->view('index');
    }

    public function validateAction()
    {
        $emails = $this->app()->getRequest()->getPost('emails');
        $result = [];
        if ($emails) {
            $emailValidator = $this->makeEmailValidator();
            $emailList = preg_split('/\r\n|\r|\n/', $emails);
            if ($emailList) {
                foreach ($emailList as $email) {
                    $valid = $emailValidator->validate($email);
                    $result[$email] = $valid;
                }
            }
        }
        return $this->view('index', compact('emails', 'result'));
    }

    protected function makeEmailValidator(): ValidatorInterface
    {
        $validatorClasses = $this->app()->getConfig()->getOrFail('validators.email');
        $emailValidator = new EmailCompositeValidator();
        foreach ($validatorClasses as $validatorClass) {
            $reflection = new \ReflectionClass($validatorClass);
            if (!$reflection->implementsInterface(ValidatorInterface::class)) {
                throw new \Exception('Invalid validator set in config '.$validatorClass);
            }
            $emailValidator->addValidator($reflection->newInstance());
        }
        return $emailValidator;
    }
}