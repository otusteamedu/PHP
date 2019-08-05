<?php

namespace crazydope\theater\Controller;

use crazydope\theater\Model\User;
use crazydope\theater\Model\View;

class ManagerController
{
    public function work()
    {
        response()->header('Set-Cookie: user='.password_hash(User::ROLE_MANAGER,PASSWORD_DEFAULT));
        $view = new View('work');
        $view->assign('token', csrfToken());
    }
}