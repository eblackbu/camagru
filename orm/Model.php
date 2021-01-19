<?php

require_once __DIR__ . '/../setup/DB.php';
require_once __DIR__ . '/ORMException.php';

/**
 * Class Model
 * Mini-analog of ORM
 */
class Model
{
    protected static ?PDO $pdo = null;

    /**
     * Model constructor.
     * @param $args
     * Передавать все поля модели в именованном массиве
     */
    public function __construct($args)
    {
        foreach ($args as $field_name => $value)
            $this->{$field_name} = $value;
    }

    protected static function __prepare_conditions(array $conditions): string
    {
        $arr = [];
        if (!$conditions)
            return '';
        foreach ($conditions as $field => $value)
            if (gettype($value) == 'array')
                $arr[] = '`' . (string)$field . '` IN (' . implode(",", $value) . ')'; // TODO костыль, проверить на иньекцию потом
            else
                $arr[] = '`' . (string)$field . '` = :' . (string)$field;

        return ' WHERE ' . implode(' AND ', $arr);
    }

    protected static function __bind_params_for_get(PDOStatement &$query, array $args)
    {
        foreach ($args as $field => $value) {
            if (gettype($value) == 'int')
                $query->bindParam(':' . $field, $value, PDO::PARAM_INT);
            else if (gettype($value) != 'array')
                $query->bindParam(':' . $field, $value, PDO::PARAM_STR);
        }
    }

    /**
     * Function for getting instance of some Model by id
     * @param array $args
     * @return Model
     * @throws ORMException if there is no selected rows or count of selected rows > 1
     */
    public static function getOne(array $args): Model
    {
        if (static::class == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $prepared_string = 'SELECT * FROM `' . static::class . '`' . self::__prepare_conditions($args);

        self::$pdo = DB::getInstance();
        $query = self::$pdo->prepare($prepared_string);
        if (!$query)
            throw new ORMException('Error in preparation of query', 227);
        self::__bind_params_for_get($query, $args);

        $result = $query->execute();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $model_data = $query->fetchall();
        $query->closeCursor();
        if (count($model_data) != 1)
            throw new ORMException('Error in getOne function - there are no selected rows or more than 1!', 229);
        $current_model = get_called_class();
        return new $current_model($model_data[0]);
    }

    /**
     * Function for array of instances of some Model. You can send filters in DjangoORM format.
     * @param array $args
     * @return array
     * @throws ORMException
     */
    public static function getMany(array $args): array
    {
        if (static::class == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $prepared_string = 'SELECT * FROM `' . static::class . '`' . self::__prepare_conditions($args);

        self::$pdo = DB::getInstance();
        $query = self::$pdo->prepare($prepared_string);
        if (!$query)
            throw new ORMException('Error in preparation query', 227);
        self::__bind_params_for_get($query, $args);

        $result = $query->execute();
        $model_data = $query->fetchall();
        $query->closeCursor();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $current_model = get_called_class();
        return array_map(function ($row) use ($current_model) {
            return new $current_model($row);
        }, $model_data);
    }

    protected function __bind_params(PDOStatement &$query, array $fields_array)
    {
        foreach ($fields_array as $field)
            if (gettype($this->{$field}) == 'int')
                $query->bindParam(':' . $field, $this->{$field}, PDO::PARAM_INT);
            else
                $query->bindParam(':' . $field, $this->{$field}, PDO::PARAM_STR);
    }

    protected function __prepare_string_for_create($needed_fields)
    {
        $columns = '(' . implode(', ', $needed_fields) . ')';
        $values = '(' . implode(', ', array_map(function ($field) {
                return ':' . $field;
            }, $needed_fields)) . ')';

        return $columns . ' VALUES ' . $values;
    }

    protected function _create(): bool
    {
        $not_null_fields = array_filter($this->_fields, function ($field) {
            return ($this->{$field} !== null);
        });

        $prepared_string = 'INSERT INTO `' . static::class . '` ' . $this->__prepare_string_for_create($not_null_fields);
        $query = self::$pdo->prepare($prepared_string);

        $this->__bind_params($query, $not_null_fields);

        $query->execute();
        $query->closeCursor();
        return True;
    }

    protected function __prepare_string_for_update(): string
    {
        $arr = [];
        foreach ($this->_fields as $field)
        {
            if ($field != 'id')
                $arr[] = '`' . (string)$field . '` = :' . (string)$field;
        }

        return implode(', ', $arr);
    }

    protected function _update(): bool
    {
        $prepared_string = $this->__prepare_string_for_update();
        $query = self::$pdo->prepare('UPDATE `' . static::class . '` SET ' . $prepared_string . 'WHERE `id` = :id');

        $this->__bind_params($query, $this->_fields);

        $query->execute();
        $query->closeCursor();
        return True;
    }

    /**
     * Function for saving an instance of some Model in database.
     * @return bool
     */
    public function save(): bool
    {
        self::$pdo = DB::getInstance();
        if (!$this->id)
            return $this->_create();
        else
            return $this->_update();
    }

    /**
     * Function for deleting an instance of some Model in database
     * @return bool
     */
    public function delete(): bool
    {
        self::$pdo = DB::getInstance();
        $query = self::$pdo->prepare('DELETE FROM `' . static::class . '` WHERE `id` = :id');
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        $query->execute();
        $query->closeCursor();
        return True;
    }
}