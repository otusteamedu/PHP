<?php
/**
 * Here request validation rules are placed.
 */
return [
    'post@/' => [
        'string' => [
            function ($requestValue) {
                //check if string does not contain space characters
                // and length must be greater than 2 (one pair of '()' at least)
                return (bool) preg_match('/^\S{2,}$/', $requestValue);
            },
            function ($requestValue) {
                $count_chars = count_chars($requestValue, 1);
                //40 and 41 are acsii codes of '(' and ')' respectively
                if ($count_chars[40] !== $count_chars[41]) {
                    return false;
                }

                for ($i = 0; $i < strlen($i); $i++) {
                    $openingBracketsNumber = 0;
                    $closingBracketsNumber = 0;

                    if ($requestValue[$i] === '(') {
                        $openingBracketsNumber++;
                    } else if ($requestValue[$i] === ')') {
                        $closingBracketsNumber++;
                    }
                    // verify string from left to right and
                    // count opening and closing brackets and if before current symbol
                    //number of closing brackets is greater than number of opening brackets return false
                    if ($closingBracketsNumber > $openingBracketsNumber) {
                        return false;
                    }
                }

                return true;
            }
        ],
    ],
    'post@/email/verify' => [
        'email' => [
            function ($requestValue) {
                return (bool) preg_match('/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/', $requestValue);
            },
            function($requestValue) {
                return (bool) filter_var($requestValue, FILTER_VALIDATE_EMAIL);
            },
            function($requestValue) {
                if (!isset(explode('@', $requestValue)[1]))
                    return false;

                return checkdnsrr(explode('@', $requestValue)[1], "MX");
            }
        ]
    ],
];
