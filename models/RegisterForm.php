<?php

namespace app\models;

use app\base\Model;


/**
 * Класс RegisterForm
 *
 * @package app\models
 */
class RegisterForm extends Model
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
     * @var string
     */
    public $password2;

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
            $this->addError( 'username', 'Не задан логин' );
        }
        if ( !$this->password ) {
            $this->addError( 'password', 'Пустой пароль' );
        }
        elseif ( $this->password != $this->password2 ) {
            $this->addError( 'password', 'Пароли не совпадают' );
        }

        if ( !$this->hasErrors() ) {
            $exist = ( $this->getDb()->users()->where( 'login', $this->username )->count() > 0 );
            if ( $exist ) {
                $this->addError( 'username', 'Пользователь с таким логином уже зарегистрирован' );
            }
            else {
                $user = new User( $this->getDb() );
                $user->login = $this->username;
                $user->setPassword( $this->password );
                $this->user = $user;
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
