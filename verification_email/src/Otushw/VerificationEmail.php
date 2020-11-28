<?php


namespace Otushw;

use Exception;

class VerificationEmail
{
    protected $rules;
    private $iterListEmails;
    protected $checkedEmailList;

    public function __construct()
    {
        try {
            $rulesFactory = new RulesFactory();
            $this->rules = $rulesFactory->getRules();
        } catch (Exception $e) {
            $view = new View($e->getMessage(), View::ERROR);
            $view->show();
        }
    }

    public function validation($listEmails)
    {
        try {
            $this->checkParameter($listEmails);
            $list = new ListEmails($listEmails);
            foreach ($this->rules as $rule) {
                $rule->execute($list);
                $this->iterListEmails[] = $list->getListEmails();
            }
            $this->unionResult();
            $data = $this->checkedEmailList;
            $type = View::STATUS;
        } catch (Exception $e) {
            $data = $e->getMessage();
            $type = View::ERROR;
        }

        $view = new View($data, $type);
        $view->show();
    }

    private function unionResult()
    {
        $unionResult = [];
        $i = 0;
        foreach ($this->iterListEmails as $listEmail) {
            foreach ($listEmail as $email => $status) {
                if (empty($i)) {
                    $unionResult[$email] = $status;
                } else {
                    $unionResult[$email] = $unionResult[$email] && $status;
                }
            }
            $i++;
        }
        $this->checkedEmailList = $unionResult;
    }

    private function checkParameter($listEmails)
    {
        if (empty($listEmails)) {
            throw new Exception('List of emails is empty');
        }
        if (!is_array($listEmails)) {
            throw new Exception('List of emails is not array');
        }
    }
}

