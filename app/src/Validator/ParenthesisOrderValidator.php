<?php


namespace Validator;


class ParenthesisOrderValidator extends AbstractValidator
{
    const VIOLATION = 'The order of opening and closing parentheses is not correct;';

    public function validate()
    {
        if (array_key_exists('string', $this->request)
            && strlen($this->request['string']) > 0) {
            $str = str_split($this->request['string']);
            $openParenthesis = 0;
            $closeParenthesis = 0;

            foreach ($str as $symbol) {
                switch ($symbol) {
                    case '(':
                        ++$openParenthesis;
                        break;
                    case ')':
                        ++$closeParenthesis;
                        break;
                }
                if ($closeParenthesis > $openParenthesis) {
                    return false;
                }
            }
        }

        return true;
    }

}