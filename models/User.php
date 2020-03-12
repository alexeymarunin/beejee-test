<?php

namespace app\models;

use app\base\Model;

class User extends Model
{
    public string $login = '';

    public string $password_hash = '';

    public function getAttributes(): array
    {
        return ['id', 'login', 'password_hash'];
    }

    public function login(string $password): bool
    {
        return ($this->password_hash == $this->generatePasswordHash($password));
    }

    public function validate(): bool
    {
        $this->clearErrors();
        if (empty($this->login)) {
            $this->addError('login', 'Не указано имя пользователя');
        }
        if (empty($this->password_hash)) {
            $this->addError('password_hash', 'Не задан пароль');
        }
        return !$this->hasErrors();
    }

    public function setPassword(string $password)
    {
        $this->password_hash = $this->generatePasswordHash($password);
    }

    protected function generatePasswordHash(string $password): string
    {
        return hash('sha1', $password);
    }

    public function isGuest(): bool
    {
        return ($this->login == 'guest');
    }

    public function isAdmin(): bool
    {
        return ($this->login == 'admin');
    }

    public static function tableName(): string
    {
        return 'users';
    }
}
