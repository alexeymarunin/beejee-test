<?php

namespace app\base;

use app\components\Database;


/**
 * Класс Model
 *
 * @package app\base
 */
class Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var Database
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;


    /**
     * @param Database $db
     */
    public function __construct( $db )
    {
        $this->db = $db;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function load( $data )
    {
        $loaded = false;
        foreach ( $data as $name => $value ) {
            if ( property_exists( $this, $name ) ) {
                $this->$name = $value;
                $loaded = true;
            }
        }

        return $loaded;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return true;
    }

    /**
     * @param string $attribute
     * @param string $error
     *
     */
    public function addError( $attribute, $error )
    {
        $this->errors[$attribute] = $error;
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function hasErrors( $attribute = null )
    {
        if ( $attribute ) {
            return isset( $this->errors[$attribute] );
        }
        return !empty( $this->errors );
    }

    /**
     *
     */
    public function clearErrors()
    {
        $this->errors = [];
    }

    /**
     * @param string $attribute
     * 
     * @return array
     */
    public function getError( $attribute )
    {
        return ( isset( $this->errors[$attribute] ) ? $this->errors[$attribute] : null );
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param bool $validate
     *
     * @return bool
     */
    public function save( $validate = true )
    {
        if ( $validate && !$this->validate() ) {
            return false;
        }

        $data = [];
        $attributes = $this->getAttributes();
        foreach ( $attributes as $attribute ) {
            $data[$attribute] = $this->$attribute;
        }

        if ( $this->isNew() ) {
            $row = $this->getDb()->createRow( static::tableName(), [] );
            $row->setData( $data );
            $data = $row->save()->getData();
            $this->load( $data );
        }
        else {
            unset( $data['id'] );
            $this->getDb()->update( static::tableName(), $data, [ 'id = ' .$this->id ] );
        }

        return true;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $this->getDb()->delete( static::tableName(), [ 'id = ' .$this->id ] );
        return true;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return !$this->id;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return [];
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return null;
    }
}
