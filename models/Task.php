<?php

namespace app\models;

use app\base\Model;
use app\components\Database;


/**
 * Класс Task
 *
 * @package app\models
 */
class Task extends Model
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $media_id = 1;

    /**
     * @var int
     */
    public $status = 0;


    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [ 'id', 'content', 'username', 'email', 'media_id', 'status' ];
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return static::imageUrl( $this->media_id, $this->getDb() );
    }

    /**
     * @param int $mediaId
     * @param Database $db
     * 
     * @return string
     */
    public static function imageUrl( $mediaId, $db )
    {
        /** @var Media $media */
        $media = $db->media()->where( 'id', $mediaId )->fetch();
        $url = ( $media ? Media::url( $media->filename ) : Media::url( null ) );

        return $url;
    }
    
    /**
     * @inheritdoc
     */
    public function validate()
    {
        $this->clearErrors();

        if ( !$this->username ) {
            $this->addError( 'username', 'Введите имя пользователя' );
        }
        if ( !$this->email ) {
            $this->addError( 'email', 'Введите email' );
        }
        else {
            $validator = new \EmailValidator\Validator();
            if ( !$validator->isValid( $this->email ) ) {
                $this->addError( 'email', 'Неверный формат email' );
            }
        }
        if ( !$this->content ) {
            $this->addError( 'content', 'Введите описание задачи' );
        }

        return !$this->hasErrors();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'tasks';
    }
}
