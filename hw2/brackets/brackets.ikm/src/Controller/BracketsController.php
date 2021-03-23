<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 12.12.20
 * Time: 13:18
 */

namespace ValidBrackets\Controller;

use Exception;
use ValidBrackets\Model\BracketsModel;
use ValidBrackets\Core\View;

class BracketsController extends Exception
{

    public function index($str) {
        $request["str"] = strip_tags($str);
        try {
            $request["mess"] = BracketsModel::isValid($request["str"]);
        } catch (Exception $e) {
            $request["mess"] = $e->getMessage() . "\n";
        }

        View::render('BracketsView', $request);
    }

    public function isValid(string $brackets) {
        
    }
}