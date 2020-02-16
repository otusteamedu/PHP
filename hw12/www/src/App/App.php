<?php declare(strict_types=1);

namespace App;

use App\Database\Database;
use App\Entities\UserEntity;

class App
{
    public function run()
    {
        $pdo = Database::init();

        $repository = new Repository($pdo);
        $mapper = $repository->load('User');

        if($_POST['id']){
            echo $mapper->findById((int) $_POST['id'])->getFirstName();
            // identityMap
            echo $mapper->findById((int) $_POST['id'])->getFirstName();
            $reqest=true;
        }

        if($_POST['findByNames']){
            $users = $mapper->findByFirstName($_POST['findByNames']);
            foreach ($users as $user) {
                echo $user->getUsername().', ';
            }
            $reqest=true;
        }

        if($_POST['insertUser'])
        {
            $user = new UserEntity(
                "stmadm",
                "Maria",
                "Stepanova",
                "Moscow",
                "2019-12-18 17:42:00",
                null,
                 "blabla"
            );
            $user->setId(61);

            echo $mapper->insert($user);
            $reqest=true;
        }
        if($_POST['updateUser']){
            $user = $mapper->findById((int) $_POST['updateUser']);
            $user->setCity('Moscow');
            $user->setUpdatedAt(date( 'Y-m-j h:i:s'));
            echo $mapper->update($user);
            $reqest=true;
        }

        if($_POST['deleteUser']){
            $user = $mapper->findById(9);
            $mapper->delete($user);
            $reqest=true;
        }

        if(!$reqest){
            echo 'Wrong reqest';
            $reqest = false;
        }
    }
}