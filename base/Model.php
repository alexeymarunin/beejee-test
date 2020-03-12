<?php

namespace app\base;

use app\components\Database;

class Model
{
    public int $id = 0;

    protected array $errors = [];

    protected Database $db;

    protected string $table;


    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function load(array $data): bool
    {
        $loaded = false;
        foreach ($data as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
                $loaded = true;
            }
        }
        return $loaded;
    }

    public function validate(): bool
    {
        return true;
    }

    public function addError(string $attribute, string $error): void
    {
        $this->errors[$attribute] = $error;
    }

    public function hasErrors($attribute = null): bool
    {
        if ($attribute) {
            return isset($this->errors[$attribute]);
        }
        return !empty($this->errors);
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }

    public function getError(string $attribute): ?string
    {
        return (isset($this->errors[$attribute]) ? $this->errors[$attribute] : null);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function save(bool $validate = true): bool
    {
        if ($validate && !$this->validate()) {
            return false;
        }
        $data = [];
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $data[$attribute] = $this->$attribute;
        }
        unset($data['id']);
        if ($this->isNew()) {
            $row = $this->getDb()->createRow(static::tableName(), []);
            $row->setData($data);
            $data = $row->save()->getData();
            $this->load($data);
        } else {
            $this->getDb()->update(static::tableName(), $data, ['id = ' . $this->id]);
        }
        return true;
    }

    public function delete(): bool
    {
        $this->getDb()->delete(static::tableName(), ['id = ' . $this->id]);
        return true;
    }

    public function isNew(): bool
    {
        return !$this->id;
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function getDb(): Database
    {
        return $this->db;
    }

    public static function tableName(): string
    {
        return null;
    }
}
