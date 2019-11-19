<?php

use App\Database;
use App\ActiveRecord;
use App\LazyLoad;
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

class App
{
    public static function init()

    {   $reqest=false;

        $pdo = Database::init();


        if($_POST['id']==1){
            echo ActiveRecord::getById($pdo, 4)->getName();
            $reqest=true;

        }
        if($_POST['namesA']==1){
           echo ActiveRecord::getByNamesLikeAUsers($pdo)->getNames();
            $reqest=true;
        }

        if($_POST['DateBetween']==1){
            echo ActiveRecord::getByDateBetweenUsers($pdo)->getNames();
            $reqest=true;
        }
        if($_POST['CointAdmins']==1){
            echo ActiveRecord::getByAdmins($pdo)->getCountAdmins();
            $reqest=true;
        }
        $LazyLoad = new LazyLoad;
        $LazyLoadActiveRecord = $LazyLoad->getActiveRecord();
        if($_POST['insertUser']==1){
           echo $insertActiveRecord = ($LazyLoadActiveRecord)
            ->setName('andrew')
            ->setLogin('Rayan')
            ->setLastName('Grey')
            ->setTel('8(323)456-33-22')
            ->setAddress('Москва, Россия, 103073')
            ->setCreated('2019-12-18 17:42:00')
            ->setAdmin('yes')
            ->setEmail('alex@yandex.ru')
            ->setPassword('12345')
            ->setAge(30)
            ->insert();
            $reqest=true;
        }
        if($_POST['updateUser']==1){
            echo $updateActiveRecord = ($LazyLoadActiveRecord)
            ->setLogin('New Homer')
            ->setName('Simson')
            ->setLastName('vinmm')
            ->setAge(54)
            ->setTel('8(323)777-77-77')
            ->setAddress('Москва, Россия, 103073')
            ->setUpdated('2019-12-18 17:42:00')
            ->setAdmin('no')
            ->setEmail('lptrg@yandex.ru')
            ->setPassword('7909')
            ->setId(2)
            ->update();
            $reqest=true;

        }
        if($_POST['deleteUser']==1){

           echo $deleteActiveRecord = ($LazyLoadActiveRecord)
            ->setId(12)
            ->delete();
            $reqest=true;

        }
        if(!$reqest){
            echo 'Wrong reqest';
        }

    }
}
