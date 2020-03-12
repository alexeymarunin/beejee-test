<?php

namespace app\models;

use app\base\Model;

use EmailValidator\Validator as EmailValidator;

class Task extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_DONE = 1;

    public string $username = '';

    public string $email = '';

    public string $content = '';

    public int $status = self::STATUS_PENDING;

    public function getAttributes(): array
    {
        return ['id', 'content', 'username', 'email', 'status'];
    }

    public function validate(): bool
    {
        $this->clearErrors();
        if (!$this->username) {
            $this->addError('username', 'Введите имя пользователя');
        }
        if (!$this->email) {
            $this->addError('email', 'Введите email');
        } else {
            $validator = new EmailValidator();
            if (!$validator->isValid($this->email)) {
                $this->addError('email', 'Неверный формат email');
            }
        }
        if (!$this->content) {
            $this->addError('content', 'Введите описание задачи');
        }
        return !$this->hasErrors();
    }

    public static function tableName(): string
    {
        return 'tasks';
    }
}
