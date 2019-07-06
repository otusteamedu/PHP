<?php
namespace Paa\Controllers;

use Paa\Models\RedisModel;

class SiteController
{

    public function actionIndex()
    {
	$redisObj = new RedisModel();
	$result = $redisObj->getEvents();
        $asset['eventsList'] = $result;
        
        $result = [ 'asset' => $asset, 'type' => 'html' ];
        return $result;
    }
    
    public function actionAddEvent()
    {
	$priority = (int)$_GET['priority'];
	$event = '::event::';
	
	if (isset($_GET['param1']) && strlen($_GET['param1']) > 0) {
	    $params['param1'] = (string)$_GET['param1'];
	}
	
	if (isset($_GET['param2']) && strlen($_GET['param2']) > 0) {
	    $params['param2'] = (string)$_GET['param2'];
	}

	if (count($params) > 0)  {
	    $redisObj = new RedisModel($redis);
	    $result = $redisObj->setEvent($priority, $params);
            $asset['result'] = $result;

	} else {
	    $asset['result'] = false;
	}
        

        $result = [ 'asset' => $asset, 'type' => 'json', 'layout' => 'no' ];
        return $result;


    }

    public function actionDelEvents()
    {
	$redisObj = new RedisModel();
	$redisObj->delEvents();
	
	$asset['result'] = true;
        $result = [ 'asset' => $asset, 'type' => 'json', 'layout' => 'no' ];
        return $result;
    }

    public function actionFindEvents()
    {
    
	if (isset($_GET['param1']) && strlen($_GET['param1']) > 0) {
	    $params['param1'] = (string)$_GET['param1'];
	}
	
	if (isset($_GET['param2']) && strlen($_GET['param2']) > 0) {
	    $params['param2'] = (string)$_GET['param2'];
	}

	$redisObj = new RedisModel();
	$result = $redisObj->getEvents();
	
	// Create array
	$findResult = [];
	
	foreach ($result as $indx => $val) {
	    $resString =  json_decode($val);
	    if ($params['param1'] == $resString->conditions->param1 
		&& $params['param2'] == $resString->conditions->param2) {
		
		$findResult[] = [ $resString->priority, $resString->conditions->param1, $resString->conditions->param2 ];

	    }
	}
	
	rsort ($findResult);
	$asset['result'] = $findResult;
	
        $result = [ 'asset' => $asset, 'type' => 'json', 'layout' => 'no' ];
        return $result;
        
    }

}