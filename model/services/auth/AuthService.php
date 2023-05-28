<?php

namespace model\services\auth;

use model\entities\User\User;
use model\forms\auth\LoginForm;
use model\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);

        if (!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Незареєстрований користувач або невірний пароль.');
        }
        return $user;
    }
}