<?php

use App\Event;

class App
{
    public static function init()
    {
        $event = new Event();
        $reqest=false;
        if($_POST['name']&&$_POST['priority']&&$_POST['conditions']){
            $event->setName($_POST['name']);
            $event->setPriority($_POST['priority']);
            $event->setConditions($_POST['conditions']);
           echo $event->save() ;
           $reqest=true;
        }
        if($_POST['params']){
          echo  $event->getPriorityEvent(['params' => $_POST['params']]);
          $reqest=true;
        }
        if($_POST['delete']==1){
            $event->deleteAllEvents();
            $reqest=true;
        }
        if(!$reqest){
            echo 'Wrong reqest';
        }

    }
}
