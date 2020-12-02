<?php
require_once "../vendor/autoload.php";

use AYakovlev\core\Sender\WorkerSender;

if ($_POST) {
    if (!empty($_POST['invoiceNo']) && is_numeric($_POST['invoiceNo'])) {
        $inputFilters = ['invoiceNo' => FILTER_SANITIZE_NUMBER_INT];
        $input = filter_input_array(INPUT_POST, $inputFilters);
        $sender = new WorkerSender();
        try {
            $sender->execute($input['invoiceNo']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        header('HTTP/1.1 200 OK');
        header('Location: http://localhost:8080/index.php');
        exit;
    } else {
        echo "ERROR! Input Invoice No!";
    }
}
