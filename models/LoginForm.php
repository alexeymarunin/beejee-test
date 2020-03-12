<?php

namespace app\models;

use app\base\Model;


class LoginForm extends Model
{
    public string $username = '';

    public string $password = '';

    // @var User
    protected $user;


    public function validate(): bool
    {
        $this->clearErrors();
        if (!$this->username) {
            $this->addError('username', 'Не указан логин');
        }
        if (!$this->password) {
            $this->addError('password', 'Не введен пароль');
        }
        if (!$this->hasErrors()) {
            $user = new User($this->getDb());
            $row = $this->getDb()->users()->where('login', $this->username)->fetch();
            if (!$row) {
                $this->addError('username', 'Неправильно введен логин и/или пароль');
            } else {
                // Проверяем пароль
                $user->load($row->getData());
                if (!$user->login($this->password)) {
                    $this->addError('password', 'Неправильно введен логин и/или пароль');
                } else {
                    $this->user = $user;
                }
            }
        }
        return !$this->hasErrors();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
