<?php
namespace Paa\Controllers;

use Paa\Models\ActiveRecord\ActiveRecordModel;

class SiteController
{

    public function __construct()
    {
    }
                                    

    public function actionIndex()
    {

	$ar = new ActiveRecordModel();
	
	$id = 211;
	$ar->setId($id);

	print_r($ar->select());
	
        $result = [ 'asset' => $asset, 'type' => 'html' ];
        
        return $result;
    }
}