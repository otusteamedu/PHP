<?php

use App\Database;
use App\ActiveRecord;
use App\LazyLoad;

class App
{
    public static function init()
    {
        $dotenv = Dotenv\Dotenv::create(__DIR__);
        $dotenv->load();
        $LazyLoad = new LazyLoad;
        $pdo = Database::init();
        echo 'var_dump(ActiveRecord::getById($pdo, 4))';
        echo '<pre>';
        var_dump(ActiveRecord::getById($pdo, 4)->getName());
        echo '</pre>';
        echo 'var_dump(ActiveRecord::getByNamesLikeAUsers($pdo)->getNames())';
        echo '<pre>';
        var_dump(ActiveRecord::getByNamesLikeAUsers($pdo)->getNames());
        echo '</pre>';
        echo 'var_dump(ActiveRecord::getByDateBetweenUsers($pdo)->getNames())';
        echo '<pre>';
        var_dump(ActiveRecord::getByDateBetweenUsers($pdo)->getNames());
        echo '</pre>';
        echo 'var_dump(ActiveRecord::getByAdmins($pdo)->getCountAdmins())';
        echo '<pre>';
        var_dump(ActiveRecord::getByAdmins($pdo)->getCountAdmins());
        echo '</pre>';
        echo '$LazyLoadActiveRecor ';
        $LazyLoadActiveRecord = $LazyLoad->getActiveRecord();
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
        echo '$updateActiveRecord ';
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
        echo '$deleteActiveRecord';
        echo $deleteActiveRecord = ($LazyLoadActiveRecord)
            ->setId(12)
            ->delete();
    }
}
