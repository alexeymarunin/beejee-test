<?php

namespace app\models;

use app\base\Model;


/**
 * Класс User
 *
 * @package app\models
 */
class User extends Model
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password_hash;


    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [ 'id', 'login', 'password_hash' ];
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function login( $password )
    {
        return ( $this->password_hash == $this->generatePasswordHash( $password ) );
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $this->clearErrors();
        if ( empty( $this->login ) ) {
            $this->addError( 'login', 'Не указано имя пользователя' );
        }
        if ( empty( $this->password_hash ) ) {
            $this->addError( 'password_hash', 'Не задан пароль' );
        }

        return !$this->hasErrors();
    }

    /**
     * @param $password
     */
    public function setPassword( $password )
    {
        $this->password_hash = $this->generatePasswordHash( $password );
    }

    /**
     * @param $password
     *
     * @return string
     */
    protected function generatePasswordHash( $password )
    {
        return md5( $password );
    }

    /**
     * @return bool
     */
    public function isGuest()
    {
        return ( $this->login == 'guest' );
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return ( $this->login == 'admin' );
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'users';
    }
}
