<?php
namespace shaydurov\brackets;

class BracketsValidator
{
    protected $line;
    public $error = '';

    /**
     * validateLine
     *
     * @param  mixed $str
     *
     * @ throws Exeption
     */
    public function validateLine($str)
    {
        try {
            if (empty($str)) {
                throw new \Exception('the line is empty');
            }

            if (!$this->isLengthCorrect($str)) {
                throw new \Exception('The line legth is wrong');
            }

            if (!$this->isOnlyBrackets($str)) {
                throw new \Exception("The line can have '(' or ')' only");
            }

            if (!$this->isBracketSequenceCorrect($str)) {
                throw new \Exception('The quantity of right and left brackets are to be equal');
            }
        } catch(\Exception $e) {
           $this->error = $e->getMessage();
        }
    }

    /**
     * isLengthCorrect
     *
     * @param  mixed $str
     *
     * @return bool
     */
    protected function isLengthCorrect($str)
    {
        return (strlen($str) % 2) == 0;
    }

    /**
     * isOnlyBrackets
     *
     * @param  mixed $str
     *
     * @return bool
     */
    protected function isOnlyBrackets($str)
    {
        return preg_match('/^[\(\)]+$/', $str);
    }

    /**
     * isBracketSequenceCorrect
     *
     * @param  mixed $str
     *
     * @return bool
     */
    protected function isBracketSequenceCorrect($str)
    {
        return (substr_count($str, ')') == substr_count($str, '(')) ? true : false;
    }
}
