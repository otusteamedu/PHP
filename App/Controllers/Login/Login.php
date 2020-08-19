<?php

namespace Controllers\Login;

use Controllers\Contracts\LoginInterface;
use Models\Users\User;
use Models\Users\UserMapper;
use Logger\Logger;
use Common\StringActions;
use Common\Cookie;


class Login
{
    /**
     * @var UserMapper
     */
    private $mapper;

    /**
     * Login constructor.
     * @param UserMapper $mapper
     */
    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Метод аутентификации пользователя по логину и паролю
     * @param User $user
     * @return bool
     */
    public function authenticate(User $user): bool
    {
        // хэшируем пароль
        $password = StringActions::generateHash($user->getPassword());
        $user->setPassword($password);

        if (!isset($_COOKIE['id']) && !isset($_COOKIE['hash'])) {

            try {
                // отправляем пользователя на проверку
                $result =  $this->mapper->checkUser($user);

            } catch (\Exception $e) {

                Logger::logToFile('userAutentification.log', $e->getMessage());

                return false;
            }

            Cookie::setLoginCookie($result);

            $hash = StringActions::generateString(10);
            $result->setHash(StringActions::generateHash($hash));

            $this->mapper->update($result);

        } else {

            try {
                $result =  $this->mapper->checkUser($user);
            } catch (\Exception $e) {

                Logger::logToFile('userAutentification.log', $e->getMessage());

                return false;
            }

            if ($result->getHash() !== $_COOKIE['hash']) {

                Cookie::removeLoginCookie($result);

                return false;
            }
        }

        $this->redirectUser(isset($_GET['uri']) ? $_GET['uri'] : '/panel/main');

        return true;
    }

    /**
     * Переадресация авторизованного пользователя на страницу кабинета
     * @param $uri
     * @return void
     */
    public function redirectUser($uri): void
    {
        header(sprintf("Location: %s", $uri));
    }



    /**
     * Метод выхода пользователя из ЛК
     * @param int $id
     * @return bool
     */
    public function logout(int $id): bool
    {
        // TODO: Implement logout() method.
    }


}