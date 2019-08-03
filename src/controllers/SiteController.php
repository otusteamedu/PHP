<?php
namespace Paa\Controllers;

use Paa\Models\RabbitModel;
use Paa\Models\PostgresqlModel;

class SiteController
{
    public function actionIndex()
    {

	$db = new PostgresqlModel();
	$asset['feedbackList'] = $db->selectMess();
        $result = [ 'asset' => $asset, 'type' => 'html' ];
        return $result;
    }


    public function actionReceive()
    {
	$db = new PostgresqlModel();
	$asset['feedbackList'] = $db->selectMessNew();
        $result = [ 'asset' => $asset, 'type' => 'json' ];
        return $result;
    }

    public function actionSend()
    {

	$msgText = (string)$_REQUEST['msgText'];
	if ($msgText != '') {
	    $rabbit = new RabbitModel();
	    $rabbit->sendMess($msgText);
	}

	$asset['msg'] = 'Спасибо за отзыв';
        $result = [ 'asset' => $asset, 'type' => 'json' ];
        return $result;
    }

    public function actionSendAnswer()
    {
	$msgId = (int)$_REQUEST['msgId'];
	$msgAnswer = (string)$_REQUEST['msgAnswer'];
	$msgStatus = (int)$_REQUEST['msgStatus'];
	if ($msgId > 0 && $msgAnswer != '') {
	    $db = new PostgresqlModel();
	    $db->updateMess($msgId, $msgAnswer, $msgStatus);
	}

	$asset['msg'] = 'ok';
        $result = [ 'asset' => $asset, 'type' => 'json' ];
        return $result;
    }

}