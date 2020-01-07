<?php

namespace Otus\Azatnizam;

class CheckPost {
    protected $postBody;

    public function __construct() {
        $this->postBody = file_get_contents('php://input');
    }

    public function getRawBody() {
        return $this->postBody;
    }

    public function getHeader($header) {
        return getallheaders()[$header] ?? false;
    }

    public function dumpAllHeaders() {
        print('<pre>');
        print_r( getallheaders() );
        print('</pre>');
    }

    public function testBody() {
        $test1 = $this->_testMethod();
        $test2 = $this->_testBodyLength();
        $test3 = $this->_testBrackets();

        return $test1 && $test2 && $test3;
    }


    /** Protected methods */

    public function _isPost() {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            return true;
        }

        return false;
    }

    protected function _testBodyLength() {
        if ( strlen($this->postBody) > 0 ) {
            return true;
        } else {
            throw new \Exception('ERROR in POST request (empty body)');
        }
    }

    protected function _testMethod() {
        if ( $this->_isPost() ) {
            return true;
        } else {
            throw new \Exception('ERROR in POST request (incorrect request method)');
        }
    }

    protected function _testBrackets() {
        $bracketsString = $this->postBody;

        $open = $close = $bracketsStatus = 0;
        for ($i=0; $i < strlen($bracketsString); $i++) {

            if ($bracketsString[$i] == '(') {
                $open++;
                $bracketsStatus++;
            } elseif ($bracketsString[$i] == ')') {
                $close++;
                $bracketsStatus--;
            }

            /** Check for brackets order (first opening bracket) */
            if ($bracketsStatus < 0) {
                throw new \Exception('ERROR in POST request (incorrect order of brackets)');
            }
        }

        if ( ($open == $close) && ($open > 0) ) {
            return true;
        }

        throw new \Exception('ERROR in POST request (incorrect brackets)');
    }
}
