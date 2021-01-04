<?php

/**
 * Class Model
 * Mini-analog of ORM
 */
class Model
{
    protected static ?PDO $pdo = null;

    public function __construct(...$kwargs)
    {
        // TODO обернуть в блок try
        foreach ($this->_fields as $field_name)
            $this->__set($kwargs[$field_name], $field_name);
        self::$pdo = DB::getInstance();
    }

    protected static function __prepare_conditions(array $conditions)
    {
        $arr = [];
        if (!$conditions)
            return '';
        foreach ($conditions as $field => $value)
            $arr[] = '`' . (string)$field . '` = :' . (string)$field;

        return 'WHERE ' . implode(' AND ', $arr);
    }

    protected static function __bind_params_for_get(PDOStatement &$query, array $args)
    {
        $model_name = static::class;
        $query->bindParam(':model_name', $model_name, PDO::PARAM_STR);
        foreach ($args as $field => $value) {
            if (gettype($value) == 'int')
                $query->bindParam(':' . $field, $value, PDO::PARAM_INT);
            else
                $query->bindParam(':' . $field, $value, PDO::PARAM_STR);
        }
    }

    /**
     * Function for getting instance of some Model by id
     * @param mixed ...$kwargs
     * @return Model
     * @throws ORMException
     */
    public static function getOne(...$kwargs): Model
    {
        if (static::class == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $prepared_string = 'SELECT * FROM :model_name ' . self::__prepare_conditions($kwargs);
        $query = self::$pdo->prepare($prepared_string);
        if (!$query)
            throw new ORMException('Error in preparation of query', 227);
        self::__bind_params_for_get($query, $kwargs);

        $result = $query->execute();
        $query->closeCursor();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $current_model = get_called_class();

        // TODO проверить количество найденных строк, кинуть эксепшн если не одна
        return new $current_model($query->fetch());
    }

    /**
     * Function for array of instances of some Model. You can send filters in DjangoORM format.
     * @param array ...$kwargs
     * @return array
     * @throws ORMException
     */
    public static function getMany(...$kwargs): array
    {
        if (static::class == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $prepared_string = 'SELECT * FROM :model_name ' . self::__prepare_conditions($kwargs);
        $query = self::$pdo->prepare($prepared_string);
        if (!$query)
            throw new ORMException('Error in preparation query', 227);
        self::__bind_params_for_get($query, $kwargs);

        $result = $query->execute();
        $query->closeCursor();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $current_model = get_called_class();
        return array_map(function ($row) use ($current_model) {
            return new $current_model($row);
        }, $query->fetchall());
    }

    protected function __bind_params(PDOStatement &$query, array $fields_array)
    {
        $model_name = static::class;
        $query->bindParam(':model_name', $model_name, PDO::PARAM_STR);

        foreach ($fields_array as $field)
            if (gettype($this->__get($field) == 'int'))
                $query->bindParam(':' . $field, $this->__get($field), PDO::PARAM_INT);
            else
                $query->bindParam(':' . $field, $this->__get($field), PDO::PARAM_STR);
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
        $query = self::$pdo->prepare('UPDATE :model_name SET ' . $prepared_string . 'WHERE `id` = :id');

        $this->__bind_params($query, $this->_fields);

        $query->execute();
        $query->closeCursor();
        return True;
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
        $needed_fields = implode(',',  array_filter($this->_fields, function ($field) {
            return $field != null;
        }));
        $prepared_string = $this->__prepare_string_for_create($needed_fields);
        $query = self::$pdo->prepare('INSERT INTO :model_name ' . $prepared_string);

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
        if (!$this->id)
            return $this->_create();
        else
            return $this->_update();
    }

    /**
     * Function for deleting an instance of some Model in database
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = self::$pdo->prepare('DELETE FROM :model_name WHERE `id` = :id');
        $query->bindParam(':model_name', $model_name, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $query->closeCursor();
        return True;
    }
}