<?php

namespace model\repositories;

use model\entities\User\User;

class UserRepository
{
    public function findByUsernameOrEmail($value): ?User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Помилка при збереженні користувача');
        }
    }

    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Помилка при видаленні користувача');
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Користувача не знайдено');
        }
        return $user;
    }
}