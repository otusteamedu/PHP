<?php

namespace crazydope\theater\Controller;

use crazydope\theater\Model\User;
use crazydope\theater\Model\View;

class DefaultController
{
    public function home(): void
    {
        response()->header('Set-Cookie: user='.password_hash(User::ROLE_GUEST,PASSWORD_DEFAULT));
        $view = new View('message');
        $view->assign('token', csrfToken());
    }

    public function status($id): void
    {
        response()->header('Set-Cookie: user='.password_hash(User::ROLE_GUEST,PASSWORD_DEFAULT));
        new View('status');
    }

    public function notFound(): string
    {
        response()->httpCode(404);
        return 'Page not found';
    }
}