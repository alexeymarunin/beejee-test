<?php

namespace app\models;

use app\base\Model;


/**
 * Класс LoginForm
 *
 * @package app\models
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    protected $user;


    /**
     * @inheritdoc
     */
    public function validate()
    {
        $this->clearErrors();

        if ( !$this->username ) {
            $this->addError( 'username', 'Не указан логин' );
        }
        if ( !$this->password ) {
            $this->addError( 'password', 'Не введен пароль' );
        }

        if ( !$this->hasErrors() ) {
            $user = new User( $this->getDb() );
            $row = $this->getDb()->users()->where( 'login', $this->username )->fetch();
            if ( !$row ) {
                $this->addError( 'username', 'Пользователь не найден' );
            }
            else {
                // Проверяем пароль
                $user->load( $row->getData() );
                if ( !$user->login( $this->password ) ) {
                    $this->addError( 'password', 'Неверный пароль' );
                }
                else {
                    $this->user = $user;
                }
            }
        }

        return !$this->hasErrors();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
