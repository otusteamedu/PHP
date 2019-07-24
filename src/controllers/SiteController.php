<?php
namespace Paa\Controllers;

use Paa\Models\ActiveRecord\ActiveRecordModel;

use Paa\Models\DataMapper\DataRecordModel;
use Paa\Models\DataMapper\DataRecordMapperModel;

use Paa\Models\TableGateway\TableGatewayModel;

use Paa\Models\RowGateway\RowGatewayModel;
use Paa\Models\RowGateway\RowGatewayFinderModel;

class SiteController
{

    public function actionIndex()
    {

/* ------------- Active Records --------------------------*/
	print "<h3>Active Record Model</h3>";

	$ar = new ActiveRecordModel();

        print "<p>Insert</p>";
	$ar->setIdHall(1);
	$ar->setCinemaName('New Active Record');
	$ar->setSeatHall(120);
	$lid = $ar->insert();
	
	$ar->setId($lid);
	print_r($ar->select($lid));

        print "<p>Update</p>";

	$ar->setIdHall(1);
	$ar->setCinemaName('Active Record');
	$ar->setSeatHall(125);

	$ar->update();

        print "<p>Select</p>";
	$ar->setId($lid);
	print_r($ar->select());


        print "<p>Delete</p>";
	$ar->delete($lid);


/* --------------------  DataMapper ---------------------- */

	print "<h3>Data Mapper Model</h3>";

	$dr = new DataRecordModel();
	$drm = new DataRecordMapperModel();	

	
	$dr->setId(1);
        print "<p>Select</p>";
	print_r($drm->select($dr->getId()));

        print "<p>Set New values</p>";
	$dr = new DataRecordModel(1, 1, 'New Name', 100);
	$drm->update($dr);

        print "<p>Select</p>";
	print_r($drm->select($dr->getId()));


	$dr->setCinemaName('New');
	$dr->setSeatHall('112');
	$drm->update($dr);

        print "<p>Select</p>";
	print_r($drm->select($dr->getId()));
	
        print "<p>Print setter CinemaName</p>";
	print_r($dr->getCinemaName());

/* ------------ Row Gateway ------------------------ */	

	$rg = new RowGatewayModel();
	$rgf = new RowGatewayFinderModel();

	print "<h3>Row Gateway Model</h3><br>";

        print "<p>Insert</p>";

	$lid = $rg->insert(1, 'New Row', 100);
	print $lid;

        print "<p>Update</p>";
	print_r($rg->update($lid, 1, 'Row Gateway', 150));

        print "<p>Select</p>";

	print_r($rgf->select($lid));

        print "<p>Delete</p>";

	print_r($rg->delete($lid));


/* ------------ Table Gateway ------------------------ */	

	$tg = new TableGatewayModel();	

	print "<h3>Table Gateway Model</h3><br>";

        print "<p>Insert</p>";

	$lid = $tg->insert(1, 'New Table', 20);
	print $lid;

        print "<p>Update</p>";
	print_r($tg->update($lid, 1, 'Table Gateway', 220));

        print "<p>Select</p>";

	print_r($tg->select($lid));


        print "<p>Delete</p>";

	print_r($tg->delete($lid));
















        $result = [ 'asset' => $asset, 'type' => 'html' ];
        
        return $result;
    }
}